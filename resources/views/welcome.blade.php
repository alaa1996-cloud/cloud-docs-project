@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="bg-white bg-opacity-90 rounded-3xl shadow-2xl max-w-md w-full p-8 text-center backdrop-blur-md">

            {{-- شعار (يمكنك تغييره إلى شعارك الخاص) --}}
            <div class="mb-6">
                <img src="{{ asset('images/logo.png') }}" alt="Cloud Docs Logo" class="mx-auto h-20">
            </div>

            <h1 class="text-3xl font-bold text-gray-800 mb-4">مرحبًا بك في Cloud Docs</h1>
            <p class="text-gray-600 mb-6">
                نظام سحابي متكامل لتحليل، فرز وتصنيف المستندات
            </p>

            @auth
                <a href="{{ route('dashboard') }}"
                   class="w-full bg-green-600 hover:bg-green-700 text-white py-3 rounded-lg font-semibold transition block mb-2">
                    الدخول إلى لوحة التحكم
                </a>
            @else
                <a href="{{ route('login') }}"
                   class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg font-semibold transition block mb-2">
                    تسجيل الدخول
                </a>
                <a href="{{ route('register') }}"
                   class="w-full border border-gray-400 hover:border-gray-600 text-gray-700 py-3 rounded-lg font-semibold transition block">
                    إنشاء حساب جديد
                </a>
            @endauth
        </div>
    </div>
@endsection
