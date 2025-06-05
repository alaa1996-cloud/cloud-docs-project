@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-lg mx-auto bg-white p-6 rounded-lg shadow-md">
            <h1 class="text-3xl font-bold mb-6 text-center">تعديل كلمة مفتاحية</h1>

            <form action="{{ route('keywords.update', $keyword->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <label for="word" class="block mb-2 text-lg font-semibold text-gray-700">الكلمة المفتاحية:</label>
                    <input
                        type="text"
                        id="word"
                        name="word"
                        value="{{ old('word', $keyword->word) }}"
                        class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required
                    >
                    @error('word')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-between items-center">
                    <button
                        type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded-md transition"
                    >
                        حفظ التغييرات
                    </button>
                    <a href="{{ route('keywords.index', $category->id) }}"
                       class="text-gray-600 hover:underline">
                        إلغاء
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
