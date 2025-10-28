<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    public function role(){
        return $this->belongsTo(Role::class);
    }

    public function articles(){
        return $this->hasMany(Article::class, 'author_id');
    }
}
