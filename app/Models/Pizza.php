<?php

namespace App\Models;

use App\Models\Ingredient;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pizza extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function ingredients()
    {
        return $this->belongsToMany(Ingredient::class, 'pizza_ingredient');
    }
}