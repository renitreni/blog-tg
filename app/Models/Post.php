<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'publication_date',
        'content'
    ];

    public function category()
    {
        return $this->belongsToMany(Category::class)->withPivot('post_id', 'category_id');
    }
}
