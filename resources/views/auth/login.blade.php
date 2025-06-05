@extends('layouts.app')

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-tr from-indigo-100 via-blue-200 to-cyan-200 dark:from-gray-900 dark:via-gray-800 dark:to-black">
        <div class="w-full max-w-md p-8 bg-white dark:bg-gray-800 rounded-xl shadow-lg">
            <h2 class="text-3xl font-extrabold text-center text-gray-800 dark:text-white mb-6">👋 مرحبًا بعودتك</h2>

            @if(session('status'))
                <div class="mb-4 text-sm text-green-600 dark:text-green-400">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- البريد الإلكتروني -->
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">البريد الإلكتروني</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                           class="mt-1 w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    @error('email')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- كلمة المرور -->
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">كلمة المرور</label>
                    <input id="password" type="password" name="password" required
                           class="mt-1 w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    @error('password')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- تذكرني -->
                <div class="flex items-center justify-between mb-6">
                    <label class="inline-flex items-center text-sm text-gray-700 dark:text-gray-300">
                        <input type="checkbox" name="remember" class="form-checkbox text-blue-600 dark:bg-gray-700 dark:border-gray-600">
                        <span class="ml-2">تذكرني</span>
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-sm text-blue-500 hover:underline">نسيت كلمة المرور؟</a>
                    @endif
                </div>

                <button type="submit"
                        class="w-full py-2 px-4 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow transition">
                    تسجيل الدخول
                </button>

                <p class="mt-4 text-center text-sm text-gray-600 dark:text-gray-400">
                    ليس لديك حساب؟
                    <a href="{{ route('register') }}" class="text-blue-500 hover:underline">إنشاء حساب جديد</a>
                </p>
            </form>
        </div>
    </div>
@endsection
