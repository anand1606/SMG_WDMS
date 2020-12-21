<x-slot name="header">

</x-slot>

<div class="py-12">
  <div class="max-w-7xl mx-auto sm:px-6 lg:px-7 text-sm" wire:poll.10s>
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
      <div class="w-full flex pb-10">
          <div class="w-3/6 mx-1">
              <input wire:model.debounce.300ms="search" type="text" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"placeholder="Search transactions...">
          </div>
          <div class="w-1/6 relative mx-1">
              <select wire:model="orderBy" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-state">
                  <option value="ip_address">Terminal</option>
                  <option value="description">Description</option>
                  <option value="ioflg">In/Out</option>

              </select>
              <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                  <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
              </div>
          </div>
          <div class="w-1/6 relative mx-1">
              <select wire:model="orderAsc" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-state">
                  <option value="1">Ascending</option>
                  <option value="0">Descending</option>
              </select>
              <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                  <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
              </div>
          </div>
          <div class="w-1/6 relative mx-1">
              <select wire:model="perPage" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-state">
                  <option>10</option>
                  <option>25</option>
                  <option>50</option>
                  <option>100</option>
              </select>
              <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                  <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
              </div>
          </div>
      </div>
  	<table class="table-auto w-full mb-6">
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

                    <td class="border px-4 py-2">{{ $terminal->ip_address }}</td>
                      <td class="border px-4 py-2">{{ $terminal->description }}</td>
                      <td class="border px-4 py-2">{{ $terminal->ioflg }}</td>
                      <td class="border px-4 py-2">{{ $terminal->approved }}</td>
                      <td class="border px-4 py-2">
  						  @if( $terminal->Status == 0)
  							<svg height="10" width="10">
  							  <circle cx="5" cy="5" r="5" stroke="black" stroke-width="1" fill="red" />
  							</svg>
  						  @else
  							<svg height="10" width="10">
  							  <circle cx="5" cy="5" r="5" stroke="black" stroke-width="1" fill="green" />
  							</svg>
  						  @endif

  					  </td>
                      <td class="border px-4 py-2">{{ $terminal->UserCount }}</td>
  					<td class="border px-4 py-2">{{ $terminal->FaceCount }}</td>
  					<td class="border px-4 py-2">{{ $terminal->FPCount }}</td>
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
      {!! $machines->links() !!}
  </div>
</div>
