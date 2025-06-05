@extends('layouts.app')

@section('content')

    <div class="container mx-auto px-4 py-6 max-w-3xl">
        <h2 class="text-3xl font-semibold mb-6 text-gray-900 dark:text-gray-100">إضافة مستند جديد</h2>

        {{-- عرض الأخطاء --}}
        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-100 text-red-800 rounded-lg border border-red-300">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6 bg-white dark:bg-gray-800 p-6 rounded-lg shadow border border-gray-200 dark:border-gray-700">
            @csrf

            <div>
                <label for="title" class="block mb-1 font-medium text-gray-700 dark:text-gray-300">العنوان <span class="text-red-500">*</span></label>
                <input
                    type="text"
                    name="title"
                    id="title"
                    value="{{ old('title') }}"
                    required
                    placeholder="ادخل عنوان المستند"
                    class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100"
                >
            </div>

            <div>
                <label for="content" class="block mb-1 font-medium text-gray-700 dark:text-gray-300">المحتوى النصي (اختياري)</label>
                <textarea
                    name="content"
                    id="content"
                    rows="5"
                    placeholder="يمكنك كتابة نص المستند هنا أو تركه فارغًا وسيتم تحليله لاحقًا"
                    class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100"
                >{{ old('content') }}</textarea>
            </div>

            <div>
                <label for="category_id" class="block mb-1 font-medium text-gray-700 dark:text-gray-300">التصنيف (اختياري)</label>
                <select
                    name="category_id"
                    id="category_id"
                    class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100"
                >
                    <option value="">-- اختر تصنيفًا --</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="file" class="block mb-1 font-medium text-gray-700 dark:text-gray-300">رفع ملف المستند <span class="text-red-500">*</span></label>
                <input
                    type="file"
                    name="document"
                    id="document"
                    accept=".pdf,.doc,.docx,.txt"
                    required
                    class="w-full text-gray-700 dark:text-gray-300"
                >
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">أنواع الملفات المدعومة: PDF، Word، نص. الحد الأقصى لحجم الملف 10 ميجابايت.</p>
            </div>

            <div class="flex items-center gap-4">
                <button type="submit" class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white rounded-md transition">
                    إضافة المستند
                </button>
                <a href="{{ route('documents.index') }}" class="px-6 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-md transition">
                    إلغاء
                </a>
            </div>
        </form>
    </div>
@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'نجاح',
                text: {!! json_encode(session('success')) !!},
                timer: 3000,
                showConfirmButton: false
            });
            @endif

            @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'خطأ',
                text: {!! json_encode(session('error')) !!},
                confirmButtonText: 'حسناً'
            });
            @endif
        });
    </script>
@endpush

