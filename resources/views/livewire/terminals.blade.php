<x-slot name="header">

</x-slot>
<div class="py-12">
  <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4" wire:poll.10s>
      @if (session()->has('message'))
      <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md my-3" role="alert">
        <div class="flex">
        <div>
        <p class="text-sm">{{ session('message') }}</p>
        </div>
        </div>
      </div>
      @endif
      <button wire:click="create()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded my-3">Create Terminal</button>
      @if($isOpen)
        @include('livewire.create')
      @endif
      <table class="table-fixed w-full">
        <thead>
        <tr class="bg-gray-100">
        <th class="px-4 py-2">IP Address.</th>
        <th class="px-4 py-2">Machine Desc</th>
        <th class="px-4 py-2">IOFLG</th>
        <th class="px-4 py-2">IsApproved</th>
        <th class="px-4 py-2">Status</th>
        <th class="px-4 py-2">Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($machines as $terminal)
          <tr>
          <td class="border px-4 py-2">{{ $terminal->ip_address }}</td>
          <td class="border px-4 py-2">{{ $terminal->description }}</td>
          <td class="border px-4 py-2">{{ $terminal->ioflg }}</td>
          <td class="border px-4 py-2">{{ $terminal->approved }}</td>
          <td class="border px-4 py-2">{{ $terminal->lastactivity }}</td>
          <td class="border px-4 py-2">
          <button wire:click="edit('{{ $terminal->ip_address }}')" class="bg-blue-500 hover:bg-blue-700 text-white  px-2 rounded">Edit</button>
          <button wire:click="delete('{{ $terminal->ip_address }}')" class="bg-red-500 hover:bg-red-700 text-white  px-2  rounded">Delete</button>
          </td>
          </tr>
        @endforeach
        </tbody>
      </table>
       {{ $machines->links() }}
    </div>
  </div>
</div>
