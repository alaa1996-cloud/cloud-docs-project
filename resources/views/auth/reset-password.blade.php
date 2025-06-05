@extends('layouts.app')

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-purple-100 to-blue-200 dark:from-gray-900 dark:to-gray-800">
        <div class="w-full max-w-md p-8 bg-white dark:bg-gray-800 rounded-xl shadow-md">
            <h2 class="text-2xl font-bold text-center text-gray-800 dark:text-white mb-6">
                🔐 إعادة تعيين كلمة المرور
            </h2>

            <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <!-- Token -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <!-- Email Address -->
                <div class="mb-4">
                    <label for="email" class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-300">البريد الإلكتروني</label>
                    <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus
                           class="w-full px-4 py-2 border rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('email')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <label for="password" class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-300">كلمة المرور الجديدة</label>
                    <input id="password" type="password" name="password" required
                           class="w-full px-4 py-2 border rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('password')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="mb-6">
                    <label for="password_confirmation" class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-300">تأكيد كلمة المرور</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required
                           class="w-full px-4 py-2 border rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <button type="submit"
                        class="w-full py-2 px-4 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow transition">
                    تحديث كلمة المرور
                </button>
            </form>
        </div>
    </div>
@endsection
