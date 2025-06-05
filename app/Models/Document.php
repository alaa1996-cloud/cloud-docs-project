<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;


    protected $fillable = ['title', 'filename', 'filepath', 'category_id', 'content', 'size'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
