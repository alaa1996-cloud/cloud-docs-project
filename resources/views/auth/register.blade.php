@extends('layouts.app')

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-tr from-blue-100 via-blue-200 to-blue-300 dark:from-gray-800 dark:via-gray-900 dark:to-black">
        <div class="w-full max-w-md p-8 bg-white dark:bg-gray-800 rounded-xl shadow-lg">
            <h2 class="text-3xl font-extrabold text-center text-gray-800 dark:text-white mb-6">✨ إنشاء حساب</h2>

            <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- الاسم -->
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">الاسم الكامل</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                           class="mt-1 w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    @error('name')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- البريد الإلكتروني -->
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">البريد الإلكتروني</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required
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

                <!-- تأكيد كلمة المرور -->
                <div class="mb-6">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300">تأكيد كلمة المرور</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required
                           class="mt-1 w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:outline-none">
                </div>

                <button type="submit"
                        class="w-full py-2 px-4 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow transition">
                    إنشاء الحساب
                </button>

                <p class="mt-4 text-center text-sm text-gray-600 dark:text-gray-400">
                    لديك حساب بالفعل؟
                    <a href="{{ route('login') }}" class="text-blue-500 hover:underline">تسجيل الدخول</a>
                </p>
            </form>
        </div>
    </div>
@endsection
