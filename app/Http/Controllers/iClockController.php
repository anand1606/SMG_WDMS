<?php

namespace App\Http\Controllers;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Terminal;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use App\Jobs\AttdLoginsertJob;
use Illuminate\Support\Str;
use HttpResponse;
use Carbon\Carbon;

class iClockController extends Controller
{
    //

    public function updateTerminalState($terminal_sn)
    {
      $machine = Terminal::where('serialno', $terminal_sn)->where('approved',true)->first();
      if(isset($machine))
      {
          $ip = $machine->ip_address;
          $dt = Carbon::now();

          Terminal::where('ip_address', $ip)->update(['lastactivity' => $dt]);
          return 1;
      }
      return 0;
    }

    public function savetransaction(Request $request)
    {
        $lines = explode(PHP_EOL, $request->GetContent());

        $ip =  $request->ip();
        $approved = false;
        $stamp = $request->query('Stamp', '');
        $sn = $request->query('SN', '');
        $machine = Terminal::where('ip_address', $ip)->where('approved',true)->first();
        if(isset($machine))
        {

          foreach ($lines as $line)
          {
              $ary = explode("\t", $line);
              $empcode = $ary[0];
              $time = $ary[1];
              $verifymode = $ary[3];

            // code...

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
                //Log::debug('record inserted');
              }else{
                //Log::debug('record already exists');
              }

            }//end for loop

        }

        return true;


    }

    public function SetMachineConfig(Request $request){
      $response = '';

      //http://172.16.12.199:8000/iclock/cdata?PushOptionsFlag=2&SN=CEZU202360241&language=69&options=all&pushver=2.4.0

      $ip = $request->ip();
      $sn = $request->query('SN');
      $pushver = $request->query('pushver');
      $dt = Carbon::now();
      $machine = Terminal::where('ip_address', $ip)->where('approved',true)->first();
      if(isset($machine))
      {
        $affected = DB::update(
          'update terminals set serialno = ? , PushVersion = ?, lastactivity =? where ip_address = ?',
            [$sn,$pushver,$dt,$ip]
          );
      }

      $response = sprintf('GET OPTION FROM: %s',$request->query('SN')) . "\n"

      .'Stamp=0' . "\n"
      . 'OpStamp=0' ."\n"
      . 'PhotoStamp=0' . "\n"
      . 'ErrorDelay=60' . "\n"
      . 'Delay=10' . "\n"
      . 'ServerVer=2.4.0' . "\n"
      . 'PushProtVer=2.4.0' . "\n"
      . 'EncryptFlag=1000000000' . "\n"
      . 'PushOptionsFlag=1' . "\n"
      . 'SupportPing=0' . "\n"
      . 'PushOptions=UserCount,TransactionCount,FingerFunOn,FPVersion,FPCount,FaceFunOn,FaceVersion,FaceCount,FvFunOn,FvVersion,FvCount,PvFunOn,PvVersion,PvCount,BioPhotoFun,BioDataFun,PhotoFunOn,~LockFunOn' . "\n"
      . 'TransTimes=00:00;14:05' . "\n"
      . 'TransInterval=1'. "\n"
      . 'TransFlag=TransData AttLog	OpLog	AttPhoto	EnrollFP	EnrollUser	FPImag	ChgUser	ChgFP	FACE	UserPic	FVEIN	BioPhoto' . "\n"
      . 'TimeZone=330' . "\n"
      . 'Realtime=1' . "\n"
      . 'Encrypt=0' . "\n"
      . 'PushOptionsFlag=1' ."\n";

      //Log::debug($response);
      return $response;
    }

    public function SaveMachineInfo($data)
    {
      //~DeviceName=MB360/ID,MAC=00:17:61:10:79:9f,TransactionCount=128,~MaxAttLogCount=10,UserCount=143,~MaxUserCount=20,PhotoFunOn=1,~MaxUserPhotoCount=2000,FingerFunOn=1,FPVersion=10,~MaxFingerCount=20,FPCount=1,FaceFunOn=1,FaceVersion=7,~MaxFaceCount=1500,FaceCount=141,FvFunOn=0,FvVersion=3,~MaxFvCount=10,FvCount=0,PvFunOn=0,PvVersion=5,~MaxPvCount=,PvCount=0,Language=69,IPAddress=172.16.12.182,~Platform=ZMM220_TFT,~OEMVendor= ZKTeco Inc. ,FWVersion=Ver 8.0.4.2-I113-02,PushVersion=Ver 2.0.36-20180926,RegDeviceType=,BioPhotoFun=,BioDataFun=,~LockFunOn=15

      log::debug($data);

      $collection = collect([]);
      $ip = '';
      $lines = explode(',', $data);

      foreach ($lines as $line)
      {
        if(Str::of($line)->startsWith(['~DeviceName','~Platform', 'MAC','UserCount',
          'FPCount','FaceCount','IPAddress','FWVersion','PushVersion'

        ]))
        {

          $ary = explode('=',$line);
          if($ary[0] == 'IPAddress')
          {
            $ip = $ary[1];
          }
          else if($ary[0] == '~DeviceName')
          {
            $ary[0] = 'DeviceName';
          }
          else if($ary[0] == '~Platform')
          {
            $ary[0] = 'Platform';
          }

          if($ary[0])
          $collection->put(  $ary[0] ,  $ary[1] );

          //Log::debug($collection->dump());
        }
      }

      //Log::debug(var_dump($collection->all()));
      //Log::debug($ip);

      if($collection->count() > 0 && $ip <> '')
      {
        $machine = Terminal::where('ip_address', $ip)->where('approved',true)->first();
        //check if machine exist
        if(isset($machine))
        {

          $collection->each(function ($items, $key) use ($ip) {

                if($key <> 'IPAddress')
                  Terminal::where('ip_address', $ip)->update([$key => $items]);


            });

            return true;
        }

      }//if collection count > 0
      return false;
    }

    public function GetRequest(Request $request)
    {

      Log::debug($request->method() . ' ' . $request->fullUrl());


      if($request->method() == 'POST')
      {

      }

      if($request->method() == 'GET' && $request->has('SN'))
      {
         //Log::debug('bhos');
         return  response('C:124:INFO',200)->header('Content-Type', 'text/plain');

      }

      return response('OK',200)
          ->withHeaders([
              'Content-Type' => 'text/plain',
              'Connection' => 'close',
              'Content-Length' => 2,
          ]);

      //return response('OK' . "\n", 200)->header('Content-Type', 'text/plain');


    }

    public function Push(Request $request)
    {

        Log::debug($request->method() . ' ' . $request->fullUrl());
        if($request->getContent())
            Log::debug($request->getContent());


        if($request->method() == 'POST')
        {
            return response('OK' . "\n", 200)->header('Content-Type', 'text/plain');
        }

        if($request->method() == 'GET')
        {

        }
        return response('OK' . "\n", 200)->header('Content-Type', 'text/plain');
    }

    public function DeviceCmd(Request $request)
    {

        Log::debug($request->method() . ' ' . $request->fullUrl());
        if($request->getContent())
            Log::debug($request->getContent());


        if($request->method() == 'POST' && $request->has('SN') && $request->query()->count() == 1)
        {
           //POST http://172.16.12.199:8000/iclock/devicecmd?SN=CEZU202360241
           /*
            ID=122&Return=0&CMD=INFO
            ~DeviceName=MB360/ID
            MAC=00:17:61:10:79:9f
            TransactionCount=98
            ~MaxAttLogCount=10
            UserCount=143
            ~MaxUserCount=20
            PhotoFunOn=1
            ~MaxUserPhotoCount=2000
            FingerFunOn=1
            ~AlgVer=10
            FPVersion=10
            ~MaxFingerCount=20
            FPCount=1
            FaceFunOn=1
            FaceVersion=7
            ~MaxFaceCount=1500
            FaceCount=141
            FvFunOn=0
            FvVersion=3
            ~MaxFvCount=10
            FvCount=0
            PvFunOn=0
            PvVersion=5
            ~MaxPvCount=0
            PvCount=0
            MainTime=1970-01-01 00:00:00
            FlashSize=202880
            FreeFlashSize=139124
            Language=69
            VOLUME=70
            DtFmt=0
            IPAddress=172.16.12.182
            IsTFT=1
            ~Platform=ZMM220_TFT
            Brightness=0
            BackupDev=0
            ~OEMVendor= ZKTeco Inc.
            FWVersion=Ver 8.0.4.2-I113-02
            PushVersion=Ver 2.0.36-20180926
            CardProtFormat=1
            ~ZKFPVersion=10
            ~SerialNumber=CEZU202360241
            IsSupportNFC=0
            AccSupportFunList=
            ~DSTF=1
            Reader1IOState=1
            MultiCardInterTimeFunOn=
            MachineTZFunOn=
            MaxMCUCardBits=
            authKey=
            BioPhotoFun=
            BioDataFun=
            VisilightFun=
                        */

            //update terminals table->based on IPAddress=172.16.12.182
            //FWVersion
            //PushVersion
            //Platform ,FaceCount,UserCount,DeviceName,MAC,FPCount
            $result = $this->SaveMachineInfo($request->getContent());

            return response('OK' . "\n", 200)->header('Content-Type', 'text/plain');
        }

        if($request->method() == 'GET')
        {
          if($request->has('SN') && $request->has('INFO'))
          {
            //http://172.16.12.199:8000/iclock/getrequest?SN=CEZU202360241&INFO=Ver%208.0.4.2-I113-02,143,1,109,172.16.12.182,10,7,12,141,111

            return response('OK' . "\n", 200)->header('Content-Type', 'text/plain');
          }
          else if ($request->has('SN') && $request->query()->count() == 1) {
            // request info command the info command
            return response('C:122:INFO' . "\n", 200)->header('Content-Type', 'text/plain');
          } else {
            // code...

            return response('OK' . "\n", 200)->header('Content-Type', 'text/plain');
          }

        }
        return response('OK' . "\n", 200)->header('Content-Type', 'text/plain');
    }

    public function CDataPOST(Request $request){

      Log::debug($request->method() . ' ' . $request->fullUrl());
      if($request->getContent())
          //Log::debug($request->getContent());


      if($request->method() == 'POST' && $request->has(['SN', 'table']) )
      {
        //operation logs -- not required
        //
         // http://172.16.12.199:8000/iclock/cdata?SN=CEZU202360241&table=OPERLOG&OpStamp=9999
        //  Log::debug($request->fullUrl());

        $tablename = $request->query('table');
        if($tablename == 'OPERLOG')
        {
            Log::debug('Get Operation Log');
            //count nos of lines in body and returen response 'OK:'NOS OF LINE
            $lines = explode(PHP_EOL, $request->GetContent());
            $response = 'OK:' . strval(count($lines));
            $sn = $request->query('SN');
			      $q = $this->updateTerminalState($sn);
            return response($response . "\n", 200)
            ->withHeaders([
                'Content-Type' => 'text/plain',
                'Connection' => 'close',
                'Content-Length' => strlen($response),
            ]);
        }
        else if($tablename == 'ATTLOG')
        {
          Log::debug('Get Attendance Log');
          //$result = $this->savetransaction($request);
          AttdLoginsertJob::dispatch($request->ip(),$request->getContent());

          return response('OK' . "\n", 200)->header('Content-Type', 'text/plain');
        }
        else if($tablename == 'options')
        {
            $result = $this->SaveMachineInfo($request->getContent());
            if($result)
            {
                Log::debug('device info saved');

            }
            else {
              Log::debug('device info not saved');
            }

            return response('OK' . "\n", 200)->header('Content-Type', 'text/plain');
        }

      }



    }

    public function CDataGET(Request $request)
    {

      Log::debug($request->method() . ' ' . $request->fullUrl());
      if($request->getContent())
          Log::debug($request->getContent());


      if($request->method() == 'GET')
      {

        $ip = $request->ip();

      // first time connection request from terminalconnect
        // http://localhost:8000/iclock/cdata?sn=zae&options=all&pushver=1.23.0
        if($request->has(['SN', 'options' , 'pushver']) && $request->query('options') == 'all')
        {

          $sn = $request->query('SN');
          $q = $this->updateTerminalState($sn);

           $response = $this->SetMachineConfig($request);
           return response($response, 200)
           ->withHeaders([
               'Content-Type' => 'text/plain',
               'Connection' => 'close',
               'Content-Length' => strlen($response),
           ]);


        }


        if($request->has(['SN', 'INFO']))
        {

            $serialno = $request->query('SN', '');
            $info = $request->query('INFO', '');
            return response('OK' . "\n", 200)->header('Content-Type', 'text/plain');
        }

        return response('OK' . "\n", 200)->header('Content-Type', 'text/plain');

      }

    }
}
