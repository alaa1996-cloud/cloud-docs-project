<?php

namespace App\Http\Controllers;

use App\Models\Keyword;
use App\Models\Category;
use Illuminate\Http\Request;

class KeywordController extends Controller
{
    // عرض الكلمات المفتاحية الخاصة بتصنيف معين
    public function index($categoryId)
    {
        $category = Category::findOrFail($categoryId);
        $keywords = $category->keywords()->get(); // استدعاء الكلمات المرتبطة بالتصنيف

        return view('keywords.index', compact('category', 'keywords'));
    }



    // عرض نموذج إضافة كلمة مفتاحية
    public function create($categoryId)
    {
        $category = Category::findOrFail($categoryId);
        return view('keywords.create', compact('category'));
    }

    // تخزين الكلمة المفتاحية
    public function store(Request $request, $categoryId)
    {
        $request->validate([
            'word' => 'required|string|max:255',
        ]);

        Keyword::create([
            'word' => $request->word,
            'category_id' => $categoryId,
        ]);

        return redirect()->route('keywords.index', $categoryId)
            ->with('success', 'تمت إضافة الكلمة المفتاحية بنجاح');
    }

    // حذف كلمة مفتاحية
    public function destroy(Keyword $keyword)
    {
        $categoryId = $keyword->category_id;
        $keyword->delete();

        return redirect()->route('keywords.index', $categoryId)
            ->with('success', 'تم حذف الكلمة المفتاحية بنجاح');
    }
    public function edit($id)
    {
        $keyword = Keyword::findOrFail($id);
        $category = $keyword->category; // لو تحتاج بيانات التصنيف

        return view('keywords.edit', compact('keyword', 'category'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'word' => 'required|string|max:255',
        ]);

        $keyword = Keyword::findOrFail($id);
        $keyword->word = $request->word;
        $keyword->save();

        return redirect()->route('keywords.index', $keyword->category_id)
            ->with('success', 'تم تحديث الكلمة المفتاحية بنجاح');
    }

}
