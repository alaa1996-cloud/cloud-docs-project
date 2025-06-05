@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex justify-center mt-4">
        <ul class="inline-flex items-center space-x-1 rtl:space-x-reverse text-sm">

            {{-- زر "السابق" --}}
            @if ($paginator->onFirstPage())
                <li aria-disabled="true">
                    <span class="px-3 py-1 bg-gray-200 text-gray-500 rounded-md cursor-not-allowed">السابق</span>
                </li>
            @else
                <li>
                    <a href="{{ $paginator->previousPageUrl() }}"
                       class="px-3 py-1 bg-white border border-gray-300 rounded-md hover:bg-gray-100 transition">
                        السابق
                    </a>
                </li>
            @endif

            {{-- الصفحات --}}
            @foreach ($elements as $element)
                {{-- فواصل (...) --}}
                @if (is_string($element))
                    <li aria-disabled="true">
                        <span class="px-3 py-1 text-gray-500">{{ $element }}</span>
                    </li>
                @endif

                {{-- روابط الصفحات --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li aria-current="page">
                                <span class="px-3 py-1 bg-blue-600 text-white rounded-md">{{ $page }}</span>
                            </li>
                        @else
                            <li>
                                <a href="{{ $url }}"
                                   class="px-3 py-1 bg-white border border-gray-300 rounded-md hover:bg-gray-100 transition">
                                    {{ $page }}
                                </a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- زر "التالي" --}}
            @if ($paginator->hasMorePages())
                <li>
                    <a href="{{ $paginator->nextPageUrl() }}"
                       class="px-3 py-1 bg-white border border-gray-300 rounded-md hover:bg-gray-100 transition">
                        التالي
                    </a>
                </li>
            @else
                <li aria-disabled="true">
                    <span class="px-3 py-1 bg-gray-200 text-gray-500 rounded-md cursor-not-allowed">التالي</span>
                </li>
            @endif

        </ul>
    </nav>
@endif
