<?php
// cleanup_duplicates.php

use App\Models\Document;
use Illuminate\Support\Facades\App;

require __DIR__.'/vendor/autoload.php';

// تشغيل تطبيق Laravel
$app = require_once __DIR__.'/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$status = $kernel->handle(
    $input = new Symfony\Component\Console\Input\ArgvInput,
    new Symfony\Component\Console\Output\ConsoleOutput
);

echo "Starting cleanup of duplicate documents...\n";

// جلب أسماء الملفات المكررة
$duplicateFiles = Document::select('filename')
    ->groupBy('filename')
    ->havingRaw('COUNT(*) > 1')
    ->pluck('filename');

foreach ($duplicateFiles as $filename) {
    echo "Processing duplicates for file: $filename\n";

    $docs = Document::where('filename', $filename)->get();

    // احتفظ بالنسخة الأولى واحذف الباقي
    $docs->shift();

    foreach ($docs as $doc) {
        $doc->delete();
        echo "Deleted duplicate document with ID: {$doc->id}\n";
    }
}

echo "Cleanup completed.\n";

$kernel->terminate($input, $status);
