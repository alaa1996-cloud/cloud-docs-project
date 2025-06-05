@extends('layouts.app')

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-100 via-purple-100 to-pink-100 dark:from-gray-900 dark:via-gray-800 dark:to-black">
        <div class="w-full max-w-md p-8 bg-white dark:bg-gray-800 rounded-xl shadow-md">
            <h2 class="text-2xl font-bold text-center text-gray-800 dark:text-white mb-6">📧 تأكيد البريد الإلكتروني</h2>

            <p class="text-center text-sm text-gray-700 dark:text-gray-300 mb-4">
                لقد أرسلنا رابط تأكيد إلى بريدك الإلكتروني. الرجاء التحقق من بريدك وتأكيد حسابك.
            </p>

            @if (session('status') === 'verification-link-sent')
                <div class="mb-4 text-sm text-green-600 dark:text-green-400 text-center">
                    تم إرسال رابط تحقق جديد إلى بريدك الإلكتروني.
                </div>
            @endif

            <div class="flex flex-col gap-4">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit"
                            class="w-full py-2 px-4 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow transition">
                        إعادة إرسال رابط التحقق
                    </button>
                </form>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="w-full py-2 px-4 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg shadow transition">
                        تسجيل الخروج
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
