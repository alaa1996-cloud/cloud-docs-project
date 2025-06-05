@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">لوحة تحكم المشرف</h1>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            <div class="bg-white rounded-2xl shadow p-5 text-center">
                <p class="text-gray-500">عدد المستخدمين</p>
                <h2 class="text-3xl font-bold text-indigo-600">{{ $usersCount }}</h2>
            </div>
            <div class="bg-white rounded-2xl shadow p-5 text-center">
                <p class="text-gray-500">عدد المستندات</p>
                <h2 class="text-3xl font-bold text-green-600">{{ $documentsCount }}</h2>
            </div>
            <div class="bg-white rounded-2xl shadow p-5 text-center">
                <p class="text-gray-500">عدد التصنيفات</p>
                <h2 class="text-3xl font-bold text-yellow-600">{{ $categoriesCount }}</h2>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">آخر المستندات المضافة</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-right text-gray-600 font-medium">العنوان</th>
                        <th class="px-4 py-2 text-right text-gray-600 font-medium">التصنيف</th>
                        <th class="px-4 py-2 text-right text-gray-600 font-medium">تاريخ الإضافة</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                    @forelse ($latestDocuments as $doc)
                        <tr>
                            <td class="px-4 py-2">{{ $doc->title }}</td>
                            <td class="px-4 py-2">{{ $doc->category->name ?? 'غير مصنف' }}</td>
                            <td class="px-4 py-2">{{ $doc->created_at->format('Y-m-d H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center px-4 py-3 text-gray-500">لا توجد مستندات حالياً</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
