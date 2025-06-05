@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">الكلمات المفتاحية لتصنيف: "{{ $category->name }}"</h1>
            <a href="{{ route('keywords.create', $category->id) }}"
               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">
                + إضافة كلمة مفتاحية
            </a>
        </div>

        <div class="overflow-x-auto bg-white rounded-lg shadow p-4">
            <table class="min-w-full text-right">
                <thead>
                <tr class="bg-gray-100">
                    <th class="px-4 py-2 border">#</th>
                    <th class="px-4 py-2 border">الكلمة</th>
                    <th class="px-4 py-2 border">الإجراءات</th>
                </tr>
                </thead>
                <tbody>
                @forelse($keywords ?? [] as $keyword)
                    <tr class="border-t">
                        <td class="px-4 py-2">{{ $loop->iteration }}</td>
                        <td class="px-4 py-2">{{ $keyword->word }}</td>
                        <td class="px-4 py-2 flex flex-wrap gap-2 justify-end">
                            <a href="{{ route('keywords.edit', $keyword->id) }}"
                               class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm">
                                تعديل
                            </a>
                            <form action="{{ route('keywords.destroy', $keyword->id) }}"
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
                        <td colspan="3" class="text-center text-gray-500 py-4">لا توجد كلمات مفتاحية بعد.</td>
                    </tr>
                @endforelse


                </tbody>
            </table>
        </div>

        <div class="mt-6">
            <a href="{{ route('categories.index') }}" class="text-blue-600 hover:underline">← الرجوع إلى التصنيفات</a>
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
                        text: 'لن تتمكن من استرجاع الكلمة بعد حذفها!',
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
        });
    </script>
@endpush
