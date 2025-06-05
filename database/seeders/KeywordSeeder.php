<?php

// database/seeders/KeywordSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Keyword;

class KeywordSeeder extends Seeder
{
    public function run()
    {
        // حذف الكلمات المفتاحية الحالية
        Keyword::truncate();

        $keywords = [
            // تصنيف: الصحة
            ['category_id' => 1, 'word' => 'hospital'],
            ['category_id' => 1, 'word' => 'medical'],
            ['category_id' => 1, 'word' => 'healthcare'],
            ['category_id' => 1, 'word' => 'treatment'],
            ['category_id' => 1, 'word' => 'diagnosis'],
            ['category_id' => 1, 'word' => 'surgery'],
            ['category_id' => 1, 'word' => 'disease'],
            ['category_id' => 1, 'word' => 'medicine'],
            ['category_id' => 1, 'word' => 'doctor'],
            ['category_id' => 1, 'word' => 'nurse'],

            // تصنيف: التعليم
            ['category_id' => 2, 'word' => 'education'],
            ['category_id' => 2, 'word' => 'student'],
            ['category_id' => 2, 'word' => 'teacher'],
            ['category_id' => 2, 'word' => 'school'],
            ['category_id' => 2, 'word' => 'university'],
            ['category_id' => 2, 'word' => 'curriculum'],
            ['category_id' => 2, 'word' => 'exam'],
            ['category_id' => 2, 'word' => 'classroom'],
            ['category_id' => 2, 'word' => 'learning'],
            ['category_id' => 2, 'word' => 'lecture'],

            // تصنيف: التكنولوجيا
            ['category_id' => 3, 'word' => 'technology'],
            ['category_id' => 3, 'word' => 'computer'],
            ['category_id' => 3, 'word' => 'software'],
            ['category_id' => 3, 'word' => 'hardware'],
            ['category_id' => 3, 'word' => 'internet'],
            ['category_id' => 3, 'word' => 'AI'],
            ['category_id' => 3, 'word' => 'robotics'],
            ['category_id' => 3, 'word' => 'cybersecurity'],
            ['category_id' => 3, 'word' => 'programming'],
            ['category_id' => 3, 'word' => 'data'],

            // تصنيف: العقارات
            ['category_id' => 4, 'word' => 'real estate'],
            ['category_id' => 4, 'word' => 'property'],
            ['category_id' => 4, 'word' => 'apartment'],
            ['category_id' => 4, 'word' => 'building'],
            ['category_id' => 4, 'word' => 'rent'],
            ['category_id' => 4, 'word' => 'lease'],
            ['category_id' => 4, 'word' => 'mortgage'],
            ['category_id' => 4, 'word' => 'land'],
            ['category_id' => 4, 'word' => 'broker'],
            ['category_id' => 4, 'word' => 'sale'],
        ];

        Keyword::insert($keywords);
    }
}
