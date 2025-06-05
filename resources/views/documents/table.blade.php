<div class="overflow-x-auto">
<table class="min-w-full   divide-y divide-gray-200 text-center">
    <thead class="bg-gray-100">
    <tr>
        <th class="px-4 py-2 cursor-pointer sort-btn" data-sort="title">
            العنوان
            <span class="sort-icon" data-key="title"></span>
        </th>
        <th class="px-4 py-2 cursor-pointer sort-btn" data-sort="filename">
            اسم الملف
            <span class="sort-icon" data-key="filename"></span>
        </th>
        <th class="px-4 py-2 cursor-pointer sort-btn" data-sort="size">
            الحجم
            <span class="sort-icon" data-key="size"></span>
        </th>
        <th class="px-4 py-2 cursor-pointer sort-btn" data-sort="category">
            التصنيف
            <span class="sort-icon" data-key="category"></span>
        </th>
        <th class="px-4 py-2 cursor-pointer sort-btn" data-sort="created_at">
            التاريخ
            <span class="sort-icon" data-key="created_at"></span>
        </th>
        <th class="px-4 py-2">
            الإجراءات
        </th>
    </tr>
    </thead>
    <tbody class="divide-y divide-gray-200">
    @forelse ($documents as $document)
        <tr class="hover:bg-gray-50">
            <td class="px-4 py-2">{{ $document->title }}</td>
            <td class="px-4 py-2">{{ $document->filename }}</td>
            <td class="px-4 py-2">{{ $document->size }}</td>
            <td class="px-4 py-2">{{ $document->category->name ?? 'غير مصنف' }}</td>
            <td class="px-4 py-2">{{ $document->created_at->format('Y-m-d') }}</td>
            <td class="px-4 py-2">
                <div class="flex justify-center items-center space-x-2 rtl:space-x-reverse">
                    <a href="{{ route('documents.show', ['document' => $document->id, 'highlight' => request('search')]) }}"
                       class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm">
                        عرض
                    </a>
                    <a href="{{ route('documents.edit', $document->id) }}"
                       class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded text-sm">
                        تعديل
                    </a>
                    <form action="{{ route('documents.destroy', $document->id) }}"
                          method="POST" class="delete-form">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm">
                            حذف
                        </button>
                    </form>
                </div>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="6" class="px-4 py-6 text-gray-500 italic">
                لا توجد مستندات مطابقة للبحث أو التصفية.
            </td>
        </tr>
    @endforelse
    </tbody>
</table>
</div>
