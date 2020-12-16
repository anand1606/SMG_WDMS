<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;


    protected $fillable = [
      'empunqid','punchdate','ioflg','ip_address','verifymode','exported',

    ];

    public function terminal()
    {
        return $this->belongsTo(Terminal::class,'ip_address');


    }
}
