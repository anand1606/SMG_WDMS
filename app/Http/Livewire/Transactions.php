<?php

namespace App\Http\Livewire;
use Livewire\WithPagination;
use Livewire\Component;
use App\Models\Transaction;
use Illuminate\Support\Carbon;
use Illuminate\Support\Arr;

class Transactions extends Component
{

    use WithPagination;
    //public $transactions;

    public $perPage = 10;
    public $search = '';
    public $orderBy = 'id';
    public $orderAsc = true;

    public function render()
    {

        return view('livewire.transactions', [
             'transactions' => Transaction::search($this->search)
                  ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
                  ->simplePaginate($this->perPage),
        ]);

      //return view('livewire.transactions');
    }
}
