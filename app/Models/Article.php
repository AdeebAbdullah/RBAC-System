<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Article extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'body', 'author_id'];

    public function author(){
        return $this->belongsTo(User::class, 'author_id');
    }
}
