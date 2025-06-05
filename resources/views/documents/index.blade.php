@extends('layouts.app')

@section('content')
    @php
        $categories = $categories ?? collect();
    @endphp

    <div class="container mx-auto px-4 py-6">
        <h1 class="text-2xl font-bold mb-6">إدارة المستندات</h1>

        {{-- إحصائيات البرنامج --}}
        <div class="mb-6 p-4 bg-gray-100 rounded-lg border border-gray-300">
            <h2 class="text-lg font-semibold mb-3">إحصائيات المستندات</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-gray-700">
                <div><span class="font-semibold">عدد المستندات:</span> {{ $stats['total_documents'] ?? 0 }}</div>
                <div><span class="font-semibold">الحجم الكلي:</span> {{ $stats['total_size'] ?? '0 MB' }}</div>
                <div><span class="font-semibold">أحدث تحديث:</span> {{ $stats['last_updated'] ?? '-' }}</div>
            </div>
        </div>

        {{-- أدوات البحث والتصفية والإضافة --}}
        <div class="flex flex-col md:flex-row md:items-center mb-6 space-y-3 md:space-y-0 md:space-x-3">
            <input
                type="text"
                id="search"
                class="flex-grow px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="ابحث عن مستند..."
                value="{{ $search_query ?? '' }}"
            >

            <button
                id="refresh-btn"
                class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md"
                title="تحديث النتائج"
                aria-label="تحديث النتائج"
            >
                🔄 تحديث
            </button>

            <select
                id="category_id"
                class="px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
                <option value="">كل التصنيفات</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ (isset($category_id) && $category_id == $category->id) ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>

            <a
                href="{{ route('documents.create') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-center"
            >
                إضافة مستند جديد
            </a>
            <a href="{{ route('categories.create') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm">
                📁 إضافة تصنيف
            </a>
        </div>

        {{-- جدول المستندات --}}
        <div id="documents-table" class="overflow-x-auto bg-white rounded-lg shadow">
            @include('documents.table', ['documents' => $documents])
        </div>

        {{-- روابط الصفحات --}}

    </div>
@endsection


    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'نجاح',
                    text: '{{ session('success') }}',
                    timer: 3000,
                    showConfirmButton: false
                });
                @endif

                @if(session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'خطأ',
                    text: '{{ session('error') }}',
                    confirmButtonText: 'حسناً'
                });
                @endif
            });
        </script>


    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let sort = 'created_at';
            let direction = 'desc';

            const searchInput = document.getElementById('search');
            const categorySelect = document.getElementById('category_id');
            const refreshBtn = document.getElementById('refresh-btn');

            function updateSortIcons() {
                document.querySelectorAll('.sort-icon').forEach(el => el.textContent = '');
                const activeIcon = document.querySelector(`.sort-icon[data-key="${sort}"]`);
                if (activeIcon) {
                    activeIcon.textContent = direction === 'asc' ? '▲' : '▼';
                }
            }

            function attachDeleteConfirmation() {
                document.querySelectorAll('.delete-form').forEach(function(form) {
                    form.addEventListener('submit', function (e) {
                        e.preventDefault();
                        Swal.fire({
                            title: 'هل أنت متأكد؟',
                            text: "لن تتمكن من التراجع بعد الحذف!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#d33',
                            cancelButtonColor: '#3085d6',
                            confirmButtonText: 'نعم، احذف!',
                            cancelButtonText: 'إلغاء'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                form.submit();
                            }
                        });
                    });
                });
            }

            function handlePaginationLinks() {
                const links = document.querySelectorAll('#pagination-links .pagination a');
                links.forEach(link => {
                    link.addEventListener('click', function (e) {
                        e.preventDefault();
                        const url = this.href;
                        fetch(url, {
                            headers: {'X-Requested-With': 'XMLHttpRequest'}
                        })
                            .then(res => res.text())
                            .then(html => {
                                const parser = new DOMParser();
                                const doc = parser.parseFromString(html, 'text/html');

                                const newTable = doc.querySelector('#documents-table');
                                const newPagination = doc.querySelector('#pagination-links');

                                if (newTable) {
                                    document.getElementById('documents-table').innerHTML = newTable.innerHTML;
                                }

                                if (newPagination) {
                                    document.getElementById('pagination-links').innerHTML = newPagination.innerHTML;
                                }

                                updateSortIcons();
                                attachDeleteConfirmation();
                                handlePaginationLinks(); // إعادة تفعيل الروابط الجديدة
                            })
                            .catch(() => alert("حدث خطأ أثناء تحميل الصفحات"));
                    });
                });
            }

            function loadDocuments() {
                const query = searchInput.value;
                const category_id = categorySelect.value;

                const url = `{{ route('documents.search') }}?query=${encodeURIComponent(query)}&category_id=${encodeURIComponent(category_id)}&sort=${sort}&direction=${direction}`;

                fetch(url, { headers: {'X-Requested-With': 'XMLHttpRequest'} })
                    .then(res => res.text())
                    .then(html => {
                        document.getElementById('documents-table').innerHTML = html;
                        updateSortIcons();
                        attachDeleteConfirmation();
                        handlePaginationLinks();
                    })
                    .catch(() => alert("حدث خطأ أثناء تحميل المستندات"));
            }

            searchInput.addEventListener('input', loadDocuments);
            categorySelect.addEventListener('change', loadDocuments);
            refreshBtn.addEventListener('click', loadDocuments);

            document.querySelectorAll('.sort-btn').forEach(btn => {
                btn.addEventListener('click', function (e) {
                    e.preventDefault();
                    const newSort = this.dataset.sort;
                    if (sort === newSort) {
                        direction = (direction === 'asc') ? 'desc' : 'asc';
                    } else {
                        sort = newSort;
                        direction = 'asc';
                    }
                    loadDocuments();
                });
            });

            attachDeleteConfirmation();
            loadDocuments();
        });
    </script>
@endpush
