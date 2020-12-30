<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Transaction;
use App\Models\Terminal;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class AttdLoginsertJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    private $ip , $data;

    public function __construct($ip,$data)
    {
      $this->ip = $ip;
      $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
      $lines = explode("\n", $this->data);
       //Log::debug($lines);
      $ip =  $this->ip;

      $machine = Terminal::where('ip_address', $ip)->where('approved',true)->first();
      if($machine)
      {
        //$i = 0; $inserted = 0;

        foreach ($lines as $line)
        {
           //$i = $i + 1;

            $ary = explode("\t", $line);
            if(count($ary) >= 4)
            {
              $empcode = $ary[0];
              $time = $ary[1];
              $verifymode = $ary[3];
              //print_r($ary);
              if(Transaction::where('ip_address',$ip)->
                where('empunqid', $empcode)->
                where('punchdate',$time)->
                where('ioflg',$machine->ioflg)->
                count() <= 0)
              {
                $transaction = Transaction::Create(
                  [
                    'ip_address' => $ip,'empunqid' => $empcode,
                    'punchdate' => $time, 'verifymode' => $verifymode ,
                    'ioflg' => $machine->ioflg , 'exported' => 0
                  ]
                );
                  // $inserted += 1;
                  //Log::debug($transaction);
              }//if record search

              //print($inserted);
            }//endif array

          }//end for loop

          unset($lines);
          unset($ary);
          unset($empcode);
          unset($time);
          unset($verifymode);
          unset($ip);
          unset($machine);
          return 1;
      }// endif terminal found..

      return 0;

    }
}
