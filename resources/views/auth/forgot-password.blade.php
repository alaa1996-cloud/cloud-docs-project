@extends('layouts.app')

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-tr from-purple-200 via-pink-100 to-yellow-100 dark:from-gray-900 dark:via-gray-800 dark:to-black">
        <div class="w-full max-w-md p-8 bg-white dark:bg-gray-800 rounded-xl shadow-md">
            <h2 class="text-2xl font-bold text-center text-gray-800 dark:text-white mb-6">🔐 نسيت كلمة المرور؟</h2>
            <p class="text-center text-sm text-gray-600 dark:text-gray-300 mb-6">
                لا تقلق! سنرسل إليك رابطًا لإعادة تعيين كلمة المرور عبر بريدك الإلكتروني.
            </p>

            @if (session('status'))
                <div class="mb-4 text-sm text-green-600 dark:text-green-400">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">البريد الإلكتروني</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                           class="mt-1 w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-purple-500 focus:outline-none">
                    @error('email')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit"
                        class="w-full py-2 px-4 bg-purple-600 hover:bg-purple-700 text-white font-semibold rounded-lg shadow transition">
                    إرسال رابط إعادة التعيين
                </button>

                <p class="mt-4 text-center text-sm text-gray-600 dark:text-gray-400">
                    تذكرت كلمة المرور؟ <a href="{{ route('login') }}" class="text-purple-500 hover:underline">تسجيل الدخول</a>
                </p>
            </form>
        </div>
    </div>
@endsection
