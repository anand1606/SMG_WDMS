<?php

namespace App\Models;
use Illuminate\Support\Carbon;
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
        'serialno','PushVersion','lastactivity',
        'UserCount','FPCount','FaceCount',
        'DeviceName','Platform','FWVersion','PushVersion','MAC'
        ,'stamp','opstamp'
    ];
    protected $attributes = [
        'approved' => false,
    ];

    public function transactions()
    {
        return $this->hasMany(Transaction::class,'ip_address');
    }

    public function getStatusAttribute()
    {

      if(!isset($this->lastactivity))
        return 0;

      $current = Carbon::now();
      $act = Carbon::parse($this->lastactivity);

      if($act->diffInMinutes($current) < 5)
        return 1;
      else if ($act->diffInMinutes($current) > 5)
        return 0;
    }

    public static function search($search)
    {
        return empty($search) ? static::query()
            : static::query()->where('ip_address', 'like', '%'.$search.'%')
                ->orWhere('ioflg', 'like', '%'.$search.'%')
                ->orWhere('description', 'like', '%'.$search.'%');
    }
}
