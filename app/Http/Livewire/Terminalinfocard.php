<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Terminal;

class Terminalinfocard extends Component
{


    public $Terminals;

    public function render()
    {
        /*
          $this->Terminals = Terminal::all();
          $this->TotalTerminals =  $this->Terminals->Count();
          $this->ActiveTerminals = $this->Terminals->where('Status', 1)->count();
          $this->NonActiveTerminals = $this->Terminals->where('Status' , 0)->count();

          $this->TotalInTerminals = $this->Terminals->where('ioflg' ,'I')->count();
          $this->ActiveInTerminals = $this->Terminals->where('ioflg' , 'I')->where('status',1)->Count();
          $this->NonActiveInTerminals = $this->Terminals->where('ioflg' , 'I')->where('status',0)->Count();

          $this->TotalOutTerminals = $this->Terminals->where('ioflg' ,'O')->count();
          $this->ActiveOutTerminals = $this->Terminals->where('ioflg' , 'O')->where('status',1)->Count();
          $this->NonActiveOutTerminals = $this->Terminals->where('ioflg' , 'O')->where('status',0)->Count();

          $this->NonActiveList = $this->Terminals->where('Status' , 0);
        */
        return view('livewire.terminalinfocard',

          [
            'TotalTerminals' => $this->GetAllTerminal(),
            'ActiveTerminals' => $this->Terminals->where('Status', 1)->count(),
            'NonActiveTerminals' => $this->Terminals->where('Status' , 0)->count(),
            'TotalInTerminals' => $this->Terminals->where('ioflg' ,'I')->count(),
            'ActiveInTerminals' => $this->Terminals->where('ioflg' , 'I')->where('status',1)->Count(),
            'NonActiveInTerminals' => $this->Terminals->where('ioflg' , 'I')->where('status',0)->Count(),
            'TotalOutTerminals' => $this->Terminals->where('ioflg' ,'O')->count(),
            'ActiveOutTerminals' => $this->Terminals->where('ioflg' ,'O')->count(),
            'NonActiveOutTerminals' =>  $this->Terminals->where('ioflg' , 'O')->where('status',0)->Count(),
            'NonActiveList' => $this->Terminals->where('Status' , 0),
          ]


        );
    }

    public function GetAllTerminal()
    {
      $this->Terminals = Terminal::all();
      return $this->Terminals->Count();
    }



}
