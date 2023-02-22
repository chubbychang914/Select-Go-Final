<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wish extends Model
{
    public $table = 'Wish';
    use HasFactory;

    public function userwish()
    {
        return $this->belongsTo(User::class);
    }

    protected $fillable = [
        'wname',
        'winfo',
        'wstyle'
    ];
}