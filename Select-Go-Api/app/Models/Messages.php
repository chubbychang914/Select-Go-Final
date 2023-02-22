<?php

namespace App\Models;

use Carbon\Traits\Timestamp;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    // This means that the current model has a foreign key that references the primary key of the User table
    public function usermessage()
    {
        return $this->belongsTo(User::class);
    }

    // 可以 mass assignment, 就是要一次把資料全部放進 model
    // for security reasons, 要說哪些欄位是可以批量賦值的
    // 使用 $fillable 允許 title 與 content 可以被批量賦值
    protected $fillable = [
        'title',
        'content'
    ];
}