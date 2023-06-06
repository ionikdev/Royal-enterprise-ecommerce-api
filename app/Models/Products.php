<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;
    protected $table = 'products';
    protected $fillable = [
        'slug',
        'name',
        'description',
        'category_id',
        'sellingPrice',
        'originalPrice',
        'brand',
        'quantity',
        'feature',
        'status' ,
        'image',
        'popular'

     
    ];

protected $with =['category'];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
