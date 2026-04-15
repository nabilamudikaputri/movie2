<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // Kolom yang bisa diisi lewat mass assignment
    protected $fillable = ['nama_kategori', 'keterangan'];

    // Relasi: satu kategori punya banyak film
    public function movies()
    {
        return $this->hasMany(Movie::class, 'category_id');
    }
}
