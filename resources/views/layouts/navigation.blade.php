<nav class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between">
        <!-- Logo -->
        <a href="{{ url('/') }}" class="text-xl font-bold text-blue-600 dark:text-blue-400">📄 مستنداتي</a>

        <!-- Links -->
        <div class="flex items-center space-x-4 rtl:space-x-reverse">
            <a href="{{ route('documents.index') }}" class="text-gray-700 dark:text-gray-300 hover:text-blue-600 font-medium">📁 المستندات</a>
            <a href="{{ route('categories.index') }}" class="text-gray-700 dark:text-gray-300 hover:text-blue-600 font-medium">📂 التصنيفات</a>
            <a href="{{ route('documents.create') }}" class="text-green-600 hover:text-green-800 font-medium">➕ مستند جديد</a>
            <a href="{{ route('categories.create') }}" class="text-green-600 hover:text-green-800 font-medium">➕ تصنيف</a>

            <!-- User Menu -->
            @auth
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center text-sm font-medium text-gray-700 dark:text-gray-200 hover:text-blue-500 focus:outline-none">
                        {{ Auth::user()->name }}
                        <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div x-show="open" @click.away="open = false"
                         class="absolute z-50 right-0 mt-2 w-48 bg-white dark:bg-gray-700 rounded-md shadow-lg py-2 border border-gray-200 dark:border-gray-600">
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600">
                            الملف الشخصي
                        </a>

                        <form id="logout-form" method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="button" onclick="confirmLogout()"
                                    class="w-full text-right px-4 py-2 text-sm text-red-600 hover:bg-red-50 dark:text-red-400 dark:hover:bg-red-600">
                                تسجيل الخروج
                            </button>
                        </form>
                    </div>
                </div>
            @endauth
        </div>
    </div>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmLogout() {
            Swal.fire({
                title: 'هل أنت متأكد أنك تريد تسجيل الخروج؟',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'نعم، تسجيل الخروج',
                cancelButtonText: 'إلغاء'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logout-form').submit();
                }
            });
        }
    </script>
</nav>
