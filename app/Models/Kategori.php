<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategori';
    protected $fillable = ['ket_kategori'];

    public function aspirasis()
    {
        return $this->hasMany(Aspirasi::class, 'kategori_id');
    }
}