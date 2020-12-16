<?php

namespace App\Http\Livewire;
use Livewire\WithPagination;
use Livewire\Component;
use App\Models\Terminal;
use Illuminate\Support\Carbon;
use Illuminate\Support\Arr;


class Terminals extends Component
{

    use WithPagination;

    public $terminals, $ip_address, $description,$ioflg,$approved,$lastactivity,$stamp,$opstamp,$serialno;
    public $isOpen = 0;

    public function render()
    {
        $this->terminals = Terminal::all();

        return view('livewire.terminals', [
            'machines' => Terminal::whereNotNull('ip_address')->paginate(10),
        ]);

        #return view('livewire.terminals');
    }

    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
    }

    public function openModal()
    {
        $this->isOpen = true;
    }
    public function closeModal()
    {
        $this->isOpen = false;
    }

    private function resetInputFields(){
        $this->ip_address = '';
        $this->description = '';
        $this->ioflg = '';
        $this->approved = false;
    }

    public function store()
    {
        $this->validate([
            'ip_address' => 'required',
            'description' => 'required',
            'ioflg' =>'required',

        ]);

        Terminal::updateOrCreate(['ip_address' => $this->ip_address], [

            'description' => $this->description,
            'ioflg' => $this->ioflg,
            'approved' => $this->approved
        ]);

        session()->flash('message',
            $this->ip_address ? 'Terminal Updated Successfully.' : 'Terminal Created Successfully.');

        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $Termnal = Terminal::where('ip_address', $id)->first();
        $this->ip_address = $id;
        $this->ioflg = $Termnal->ioflg;
        $this->description = $Termnal->description;
        $this->approved = $Termnal->approved;

        $this->openModal();
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function delete($id)
    {
        Terminal::firstOrFail()->where('ip_address', $id)->delete();
        session()->flash('message', 'Terminal Deleted Successfully.');
    }


}
