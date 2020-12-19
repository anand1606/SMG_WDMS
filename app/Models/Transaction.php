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

    public static function search($search)
    {
        return empty($search) ? static::query()
            : static::query()->where('id', 'like', '%'.$search.'%')
                ->orWhere('ip_address', 'like', '%'.$search.'%')
                ->orWhere('empunqid', 'like', '%'.$search.'%')
                ->orWhere('ioflg', 'like', '%'.$search.'%')
                ->orWhere('verifymode', 'like', '%'.$search.'%')
                ->orWhere('punchdate', 'like', '%'.$search.'%')
                ->orWhere('exported', 'like', '%'.$search.'%')

                ;
    }
}
