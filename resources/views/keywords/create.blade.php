@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 max-w-md">
        <h1 class="text-2xl font-bold mb-6">إضافة كلمة مفتاحية لتصنيف: {{ $category->name }}</h1>

        <form action="{{ route('keywords.store', $category->id) }}" method="POST" class="bg-white shadow-md rounded px-8 py-6">
            @csrf

            <div class="mb-4">
                <label for="word" class="block text-gray-700 font-semibold mb-2">الكلمة المفتاحية</label>
                <input type="text" name="word" id="word" value="{{ old('word') }}"
                       class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                @error('word')
                <p class="text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-between items-center">
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md">
                    حفظ
                </button>
                <a href="{{ route('keywords.index', $category->id) }}" class="text-gray-600 hover:underline">إلغاء</a>
            </div>
        </form>
    </div>
@endsection
