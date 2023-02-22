<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;

    protected $fillable = [
        'pname',
        'pstyle',
        'pprice',
        'pinfo',
        'pcost',
        'pprofit',
        'pqty',
        'psold',
        'pshelf',
        'ppic_main',
        'ppic_1',
        'ppic_2p',
        'ppic_3',
        'ppic_4',
        'user_id'
    ];
}