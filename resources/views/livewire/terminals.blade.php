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
        <th class="px-4 py-2">IP Address</th>
        <th class="px-4 py-2">Machine Desc</th>
        <th class="px-4 py-2">IOFLG</th>
        <th class="px-4 py-2">Is Approved</th>
        <th class="px-4 py-2">Status</th>
        <th class="px-4 py-2">Users</th>
        <th class="px-4 py-2">Faces</th>
        <th class="px-4 py-2">Fingers</th>


        <th class="px-4 py-2">Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($machines as $terminal)
          <tr>
          <td class="border px-4 py-2 "><div class="text-xs flex space-x-1 justify-around">{{ $terminal->ip_address }}</div></td>
          <td class="border px-4 py-2 "  ><div class="text-xs flex space-x-1 justify-around">{{ $terminal->description }}</div></td>
          <td class="border px-4 py-2 " ><div class="text-xs flex space-x-1 justify-around">{{ $terminal->ioflg }}</div></td>
          <td class="border px-4 py-2 " ><div class="text-xs flex space-x-1 justify-around">{{ $terminal->approved }}</div></td>
          <td class="border px-4 py-2 ">
            <div class="text-xs flex space-x-1 justify-around">

              @if( $terminal->Status == 0)
                <svg height="10" width="10">
                  <circle cx="5" cy="5" r="5" stroke="black" stroke-width="1" fill="red" />
                </svg>
              @else
                <svg height="10" width="10">
                  <circle cx="5" cy="5" r="5" stroke="black" stroke-width="1" fill="green" />
                </svg>
              @endif

          </div></td>


          <td class="border px-4 py-2 "><div class="text-xs flex space-x-1 justify-around">{{ $terminal->UserCount }}</div></td>
          <td class="border px-4 py-2 "><div class="text-xs flex space-x-1 justify-around">{{ $terminal->FaceCount }}</div></td>
          <td class="border px-4 py-2 "><div class="text-xs flex space-x-1 justify-around">{{ $terminal->FPCount }}</div></td>

          <td class="border px-4 py-2">
            <div class="flex space-x-1 justify-around">
                <button wire:click="edit('{{ $terminal->ip_address }}')" class="p-1 text-red-600 hover:bg-red-600 hover:text-white rounded">
                  <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path></svg>
                </button>

                <button wire:click="delete('{{ $terminal->ip_address }}')" class="p-1 text-red-600 hover:bg-red-600 hover:text-white rounded">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                </button>
            </div>
          </td>
          </tr>
        @endforeach
        </tbody>
      </table>
       {{ $machines->links() }}
    </div>
  </div>
</div>
