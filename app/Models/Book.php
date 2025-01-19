<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title', 'description', 'price', 'stock', 'author_id', 'category_id'
    ];

    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function orders()
    {
        return $this->belongsToMany(Order::class)->withPivot('quantity', 'price');
    }

    public function scopeSearch($query, $searchTerm)
    {
        if ($searchTerm) {
            return $query->where('title', 'like', '%' . $searchTerm . '%')
                         ->orWhereHas('author', function($q) use ($searchTerm) {
                             $q->where('name', 'like', '%' . $searchTerm . '%');
                         });
        }

        return $query;
    }
}
