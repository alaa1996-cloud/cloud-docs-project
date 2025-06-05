<?php



namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Document;
use Illuminate\Support\Str;
use Smalot\PdfParser\Parser;         // ✅ استدعاء المكتبة هنا فقط
use PhpOffice\PhpWord\IOFactory;
use App\Models\Category;
use Illuminate\Support\Facades\Log;
class DocumentController extends Controller
{
    public function index(Request $request)
    {
        $search_query = $request->input('query', '');
        $categoryId = $request->input('category_id');
        $sort = $request->input('sort', 'created_at');
        $direction = $request->input('direction', 'desc');

        $query = Document::query();

        if ($search_query) {
            $query->where(function ($q) use ($search_query) {
                $q->where('title', 'like', "%{$search_query}%")
                    ->orWhere('content', 'like', "%{$search_query}%");
            });
        }

        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        $documents = $query->with('category')
            ->orderBy($sort, $direction)
            ->get();

        $categories = Category::orderBy('name')->get();

        $stats = [
            'total_documents' => Document::count(),
            'total_size' => number_format(Document::sum('size'), 2) . ' KB',
            'last_updated' => optional(Document::latest('updated_at')->first())->updated_at?->format('Y-m-d'),
        ];


        if ($request->ajax()) {
            return view('documents.table', compact('documents'))->render();
        }


        return view('documents.index', [
            'documents' => $documents,
            'categories' => $categories,
            'search_query' => $search_query,
            'category_id' => $categoryId,
            'stats' => $stats,
        ]);
    }











    public function create()
    {
        $categories = Category::all();
        return view('documents.create', compact('categories'));
    }



    public function show($id)
    {
        $document = Document::findOrFail($id);
        return view('documents.show', compact('document'));
    }


    public function destroy($id)
    {
        $document = Document::findOrFail($id);

        // تحقق أن filepath موجود وأن الملف فعلاً موجود في التخزين
        if ($document->filepath && Storage::disk('public')->exists($document->filepath)) {
            Storage::disk('public')->delete($document->filepath);
        }

        $document->delete();

        return redirect('/documents')->with('success', 'تم حذف المستند بنجاح.');
    }
    public function edit($id)
    {
        $document = Document::findOrFail($id);
        return view('documents.edit', compact('document'));
    }

    public function update(Request $request, $id)
    {
        $document = Document::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx,txt|max:20480' // 20MB limit مثال
        ]);

        $document->title = $request->input('title');
        $document->content = $request->input('content');

        // إذا تم رفع ملف جديد، احذف القديم واحتفظ بالجديد
        if ($request->hasFile('file')) {
            // حذف الملف القديم
            if ($document->filepath && Storage::disk('public')->exists($document->filepath)) {
                Storage::disk('public')->delete($document->filepath);
            }

            // حفظ الملف الجديد
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('documents', $filename, 'public');

            $document->filename = $filename;
            $document->filepath = $path;
        }

        $document->save();

        return redirect()->route('documents.index')->with('success', 'تم تحديث المستند بنجاح.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'document' => 'required|file|mimes:pdf,doc,docx|max:10240', // 10MB max
        ]);

        try {
            $file = $request->file('document');
            $originalFilename = $file->getClientOriginalName();
            $filename = $originalFilename;
            $filepath = $file->store('documents');
            $extension = strtolower($file->getClientOriginalExtension());

            // تحقق من تكرار اسم الملف
            if (Document::where('filename', $filename)->exists()) {
                return redirect()->back()->with('error', 'اسم الملف مكرر مسبقاً، الرجاء اختيار ملف آخر أو إعادة تسميته.');
            }

            // استخراج النص بناءً على نوع الملف
            if (in_array($extension, ['doc', 'docx'])) {
                $content = $this->extractTextFromDocx(storage_path('app/' . $filepath));
            } elseif ($extension === 'pdf') {
                $content = $this->extractTextFromPdf(storage_path('app/' . $filepath));
            } else {
                $content = '';
            }

            // تصنيف المستند تلقائيًا بناءً على محتوى النص
            $autoCategoryId = $this->classifyDocument($content);

            // إذا كان التصنيف التلقائي موجود نستخدمه، وإلا نستخدم التصنيف المدخل من الفورم
            $categoryIdToSave = $autoCategoryId ?? $request->input('category_id');

            // حفظ المستند
            Document::create([
                'title' => $request->input('title'),
                'filename' => $filename,
                'filepath' => $filepath,
                'category_id' => $categoryIdToSave,
                'content' => $content,
                'size' => $file->getSize() / 1024, // الحجم بالكيلوبايت
            ]);

            return redirect()->route('documents.index')->with('success', 'تم حفظ المستند بنجاح.');
        } catch (\Exception $e) {
            \Log::error('خطأ أثناء حفظ المستند: ' . $e->getMessage());
            return redirect()->back()->with('error', 'حدث خطأ أثناء حفظ المستند. يرجى المحاولة لاحقاً.');
        }
    }
















    // دالة استخراج النص الكامل من ملف وورد (docx)
    private function extractText($filePath)
    {
        $phpWord = IOFactory::load($filePath);

        $text = '';

        foreach ($phpWord->getSections() as $section) {
            foreach ($section->getElements() as $element) {
                $text .= $this->extractFromElement($element);
            }
        }

        return $text;
    }




    public function search(Request $request)
    {
        $query = $request->input('query');
        $category_id = $request->input('category_id');
        $sort = $request->input('sort', 'created_at');
        $direction = $request->input('direction', 'desc');

        $documents = Document::query()
            ->when($query, fn($q) => $q->where('title', 'like', "%$query%"))
            ->when($category_id, fn($q) => $q->where('category_id', $category_id))
            ->orderBy($sort, $direction)
            ->get();

        if ($request->ajax()) {
            return view('documents.table', compact('documents'))->render();
        }

        return view('documents.index', compact('documents'));
    }














// دالة التصنيف تعتمد على وجود جدول keywords مرتبط بفئة category
    private function classifyDocument($content)
    {
        $keywords = \App\Models\Keyword::all();
        $contentLower = mb_strtolower($content);

        foreach ($keywords as $keyword) {
            $wordLower = mb_strtolower($keyword->word);
            if (strpos($contentLower, $wordLower) !== false) {
                return $keyword->category_id;
            }
        }

        return null;
    }


    private function extractFromElement($element)
    {
        $text = '';

        if ($element instanceof \PhpOffice\PhpWord\Element\Text) {
            $text .= $element->getText() . ' ';
        } elseif ($element instanceof \PhpOffice\PhpWord\Element\TextRun) {
            foreach ($element->getElements() as $child) {
                $text .= $this->extractFromElement($child);
            }
        } elseif ($element instanceof \PhpOffice\PhpWord\Element\Table) {
            foreach ($element->getRows() as $row) {
                foreach ($row->getCells() as $cell) {
                    foreach ($cell->getElements() as $cellElement) {
                        $text .= $this->extractFromElement($cellElement);
                    }
                }
            }
        } elseif (method_exists($element, 'getElements')) {
            foreach ($element->getElements() as $subElement) {
                $text .= $this->extractFromElement($subElement);
            }
        }

        return $text;
    }


    private function getTextFromElement($element)
    {
        $text = '';

        if ($element instanceof \PhpOffice\PhpWord\Element\Text) {
            $text .= $element->getText();
        } elseif ($element instanceof \PhpOffice\PhpWord\Element\TextRun) {
            foreach ($element->getElements() as $childElement) {
                if ($childElement instanceof \PhpOffice\PhpWord\Element\Text) {
                    $text .= $childElement->getText();
                }
            }
        }

        // يتم تجاهل الصور والعناصر الأخرى تلقائيًا

        return $text;
    }

    private function extractTextFromPdf($filePath)
    {
        try {
            $parser = new \Smalot\PdfParser\Parser();
            $pdf = $parser->parseFile($filePath);
            $text = $pdf->getText();

            return $text;
        } catch (\Exception $e) {
            Log::error('خطأ في استخراج نص PDF: ' . $e->getMessage());
            return '';
        }
    }


    private function extractTextFromDocx($filePath)
    {
        $zip = new \ZipArchive;
        $text = '';

        if ($zip->open($filePath) === true) {
            $xml = $zip->getFromName('word/document.xml');
            $zip->close();

            if ($xml) {
                $xmlObject = simplexml_load_string($xml);
                if ($xmlObject === false) {
                    return '';
                }

                $nodes = $xmlObject->xpath('//w:t');
                foreach ($nodes as $node) {
                    $text .= (string) $node . ' ';
                }

                return trim($text);
            }
        }

        return '';
    }





public function table(Request $request)
{
    $sort = $request->get('sort', 'created_at');
    $direction = $request->get('direction', 'desc');
    $search = $request->get('search', '');

    $allowedSorts = ['title', 'created_at'];
    if (!in_array($sort, $allowedSorts)) {
        $sort = 'created_at';
    }
    if (!in_array($direction, ['asc', 'desc'])) {
        $direction = 'desc';
    }

    $query = Document::with('category');

    if ($search) {
        $query->where(function($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
                ->orWhere('filename', 'like', "%{$search}%")
                ->orWhere('content', 'like', "%{$search}%");
        });
    }

    $documents = $query->orderBy($sort, $direction)->paginate(10);

    return view('documents.table', compact('documents', 'search'));

}
}
