<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    use HasFactory;
    protected $table = 'bukus';
    protected $fillable = ['judul', 'penulis', 'harga', 'tgl_terbit', 'foto', 'foto_square'];
    protected $casts = ['tgl_terbit' => 'datetime'];
}

