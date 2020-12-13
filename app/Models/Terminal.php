<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Terminal extends Model
{
    use HasFactory;

    protected $primaryKey = 'ip_address';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'ip_address', 'description','ioflg','approved',
        'serialno','pushver','lastactivity','usercount',
        'fingerCount','transactions','fpVersion',
        'faceVersion','faceReg','faceCount'
    ];
    protected $attributes = [
        'approved' => false,
    ];

    public function transactions()
    {
        return $this->hasMany(Transaction::class,'ip_address');
    }
}
