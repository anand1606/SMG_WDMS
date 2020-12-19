<?php

namespace App\Http\Livewire;

use App\Models\Termimal;
use Livewire\Component;
use App\Models\Terminal;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\TimeColumn;
use Mediconesystems\LivewireDatatables\NumberColumn;
use Mediconesystems\LivewireDatatables\BooleanColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class Terminaltb extends LivewireDatatable
{



    public function builder()
    {

        return Terminal::whereNotNull('ip_address');
    }

    public function columns()
    {

          return [

              Column::name('ip_address')
                  ->label('Terminal IP')
                  ->defaultSort('asc')
                  ->searchable()
                  ->filterable(),
              Column::name('description')
                    ->label('Terminal Name')
                    ->defaultSort('asc')
                    ->searchable()
                    ->filterable(),
              Column::name('ioflg')
                    ->label('In/Out')
                    ->defaultSort('asc')
                    ->searchable()
                    ->filterable(),
              BooleanColumn::name('approved')
                    ->label('Approved')
                    ->defaultSort('asc')
                    ->searchable()
                    ->filterable(),
              BooleanColumn::name('Status')
                  ->label('Status')
                  ->defaultSort('asc')
                  ->searchable()
                  ->filterable(),
              Column::name('UserCount')->defaultSort('asc'),
              Column::name('FaceCount')->defaultSort('asc'),
              Column::name('FPCount')->defaultSort('asc'),
              Column::name('PushVersion')->defaultSort('asc'),
              Column::callback(['ip_address'], function ($id) {
                return view('livewire.terminals', ['id' => $id]);
            }),


        ];
    }




}
