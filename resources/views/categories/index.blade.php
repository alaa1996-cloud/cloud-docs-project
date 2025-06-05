@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">إدارة التصنيفات</h1>
            <a href="{{ route('categories.create') }}"
               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">
                + إضافة تصنيف جديد
            </a>
        </div>

        <div class="overflow-x-auto bg-white rounded-lg shadow p-4">
            <table class="min-w-full text-right">
                <thead>
                <tr class="bg-gray-100">
                    <th class="px-4 py-2 border">#</th>
                    <th class="px-4 py-2 border">اسم التصنيف</th>
                    <th class="px-4 py-2 border">الكلمات المفتاحية</th>
                    <th class="px-4 py-2 border">الإجراءات</th>
                </tr>
                </thead>
                <tbody>
                @forelse($categories as $category)
                    <tr class="border-t">
                        <td class="px-4 py-2">{{ $loop->iteration }}</td>
                        <td class="px-4 py-2">{{ $category->name }}</td>
                        <td class="px-4 py-2">
                            @if($category->keywords && $category->keywords->count())
                                <ul class="list-disc pr-4">
                                    @foreach($category->keywords as $keyword)
                                        <li class="text-sm text-gray-700">{{ $keyword->word }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <span class="text-gray-400">لا توجد كلمات</span>
                            @endif
                        </td>
                        <td class="px-4 py-2 flex flex-wrap gap-2 justify-end">
                            <a href="{{ route('keywords.index', $category->id) }}"
                               class="bg-purple-600 hover:bg-purple-700 text-white px-3 py-1 rounded text-sm">
                                إدارة الكلمات
                            </a>

                            <a href="{{ route('categories.edit', $category->id) }}"
                               class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm">
                                تعديل
                            </a>

                            <form action="{{ route('categories.destroy', $category->id) }}"
                                  method="POST" class="delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm">
                                    حذف
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-4 py-4 text-center text-gray-500">لا توجد تصنيفات حالياً.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.delete-form').forEach(function (form) {
                form.addEventListener('submit', function (e) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'هل أنت متأكد من الحذف؟',
                        text: 'لن تتمكن من استرجاع هذا العنصر بعد الحذف!',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'نعم، احذف!',
                        cancelButtonText: 'إلغاء'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });

            @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'نجاح',
                text: '{{ session('success') }}',
                confirmButtonText: 'حسنًا'
            });
            @endif

            @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'خطأ',
                text: '{{ session('error') }}',
                confirmButtonText: 'حسنًا'
            });
            @endif
        });
    </script>
@endpush
