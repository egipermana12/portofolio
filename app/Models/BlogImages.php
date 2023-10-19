<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BlogImages extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_blog',
        'image',
    ];

    public function Blog() :BelongsTo
    {
        return $this->belongsTo(Blog::class);
    }

}
