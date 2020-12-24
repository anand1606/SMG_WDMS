<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Terminal;

class Terminalinfocard extends Component
{

    public $TotalTerminals,$ActiveTerminals, $NonActiveTerminals;
    public $TotalInTerminals,$ActiveInTerminals,$NonActiveInTerminals;
    public $TotalOutTerminals,$ActiveOutTerminals,$NonActiveOutTerminals;
    public $Terminals;
    public $NonActiveList;

    public function render()
    {
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

        return view('livewire.terminalinfocard');
    }

}
