@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 max-w-md">
        <h1 class="text-2xl font-bold mb-6">إضافة تصنيف جديد</h1>

        <form action="{{ route('categories.store') }}" method="POST" class="bg-white shadow-md rounded px-8 py-6">
            @csrf

            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-semibold mb-2">اسم التصنيف</label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name') }}"
                    required
                    class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                @error('name')
                <p class="text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-between items-center">
                <button
                    type="submit"
                    class="bg-green-600 hover:bg-green-700 text-white font-semibold px-4 py-2 rounded-md"
                >
                    حفظ
                </button>

                <a href="{{ route('categories.index') }}"
                   class="text-gray-600 hover:underline">
                    إلغاء
                </a>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if(session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'تمت العملية',
                text: '{{ session('success') }}',
                confirmButtonText: 'حسنًا'
            });
        </script>
    @endif
@endpush
