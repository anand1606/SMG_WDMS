<?php

namespace App\Models;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
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
      $current->setTimezone('Asia/Kolkata');

      $act = Carbon::parse($this->lastactivity);
      $act->setTimezone('Asia/Kolkata');

      //Log::debug($act);
      //Log::debug($current->diffInMinutes($act));
      //Log::debug($current);
      //Log::debug($act);

      if($current->diffInMinutes($act) < 15)
      {

        return 1;
      }
      else if ($current->diffInMinutes($act) > 15)
        { return 0; }
    }

    public static function search($search)
    {
        return empty($search) ? static::query()
            : static::query()->where('ip_address', 'like', '%'.$search.'%')
                ->orWhere('ioflg', 'like', '%'.$search.'%')
                ->orWhere('description', 'like', '%'.$search.'%');
    }
}
