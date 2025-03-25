<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Reviews extends Model
{
    use HasFactory;

    protected $fillable = [
    'book_id',
    'user_id',
    'rating', 
    'comment'];

    public function book()
    {
        return $this->belongsTo(Books::class);
    }

   
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}