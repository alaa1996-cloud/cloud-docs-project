@extends('layouts.app')

@section('content')
    @php
        $content = $document->content ?: 'لم يتم تحليل المحتوى بعد.';
        $highlight = request('highlight') ?? '';
    @endphp

    <div class="container mx-auto px-6 py-8 rtl" dir="rtl">
        <h1 class="text-4xl font-extrabold mb-6 text-gray-900 dark:text-gray-100">{{ $document->title }}</h1>

        <div class="mb-4 text-gray-700 dark:text-gray-300">
            <span class="font-semibold">📅 تاريخ الإضافة:</span>
            <span>{{ $document->created_at->format('Y-m-d H:i') }}</span>
        </div>

        <div class="mb-6">
            <a href="{{ asset('storage/' . $document->filepath) }}" target="_blank"
               class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg transition shadow-md">
                📄 فتح الملف
            </a>
        </div>

        <div>
            <p class="mb-2 font-semibold text-lg text-gray-800 dark:text-gray-200">📑 محتوى المستند:</p>
            <div
                class="bg-gray-50 dark:bg-gray-800 p-6 rounded-lg border border-gray-300 dark:border-gray-700 text-gray-900 dark:text-gray-100 whitespace-pre-wrap max-h-[500px] overflow-auto shadow-inner">
                @if($highlight && mb_strlen($highlight) >= 3)
                    {!! preg_replace('/(' . preg_quote($highlight, '/') . ')/iu', '<mark class="bg-yellow-300 rounded px-1">$1</mark>', e($content)) !!}
                @else
                    {{ $content }}
                @endif
            </div>
        </div>

        <div class="mt-8">
            <a href="{{ route('documents.index') }}"
               class="inline-block bg-gray-500 hover:bg-gray-600 text-white px-5 py-2 rounded-lg transition shadow-md">
                ⬅️ العودة للقائمة
            </a>
        </div>
    </div>
@endsection
