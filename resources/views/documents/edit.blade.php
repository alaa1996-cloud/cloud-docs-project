@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-6 max-w-3xl">
        <h2 class="text-2xl font-semibold mb-6 text-gray-900 dark:text-gray-100">تعديل المستند</h2>

        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-100 text-red-800 rounded-lg border border-red-300">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('documents.update', $document->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6 bg-white dark:bg-gray-800 p-6 rounded-lg shadow border border-gray-200 dark:border-gray-700">
            @csrf
            @method('PUT')

            <div>
                <label for="title" class="block mb-1 font-medium text-gray-700 dark:text-gray-300">العنوان</label>
                <input
                    type="text"
                    name="title"
                    id="title"
                    value="{{ old('title', $document->title) }}"
                    required
                    class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100"
                >
            </div>

            <div>
                <label for="content" class="block mb-1 font-medium text-gray-700 dark:text-gray-300">المحتوى النصي</label>
                <textarea
                    name="content"
                    id="content"
                    rows="5"
                    class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100"
                >{{ old('content', $document->content) }}</textarea>
            </div>

            <div>
                <label for="file" class="block mb-1 font-medium text-gray-700 dark:text-gray-300">رفع ملف جديد (اختياري)</label>
                <input
                    type="file"
                    name="file"
                    id="file"
                    class="w-full text-gray-700 dark:text-gray-300"
                >
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">إذا لم ترفع ملف جديد، سيبقى الملف الحالي.</p>
            </div>

            <div class="flex items-center gap-4">
                <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md transition">
                    تحديث المستند
                </button>
                <a href="{{ route('documents.index') }}" class="px-6 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-md transition">
                    إلغاء
                </a>
            </div>
        </form>
    </div>
@endsection
