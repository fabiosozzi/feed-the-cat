<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cat extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'breed',
        'date_of_birth',
        'weight',
        'user_id'
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
