<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Category;

class CategorySeeder extends Seeder
{
public function run()
{
// تعطيل القيود الأجنبية مؤقتًا
DB::statement('SET FOREIGN_KEY_CHECKS=0;');

// تفريغ الجدول
Category::truncate();

// إعادة تفعيل القيود
DB::statement('SET FOREIGN_KEY_CHECKS=1;');

// إضافة التصنيفات
Category::insert([
['id' => 1, 'name' => 'Health'],
['id' => 2, 'name' => 'Education'],
['id' => 3, 'name' => 'Technology'],
['id' => 4, 'name' => 'Real estate'],
]);
}
}
