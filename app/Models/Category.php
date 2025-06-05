<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'keywords'];

    public function documents()
    {

        return $this->hasMany(Document::class);
    }
    public function keywords()
    {
        return $this->hasMany(Keyword::class, 'category_id', 'id');
    }
}
