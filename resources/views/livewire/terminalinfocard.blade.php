<x-slot name="header">

</x-slot>
<div  wire:poll.10s>
  
  <h2 class="text-xl text-gray-900 font-medium leading-8">WDMS</h2>
  <div class="grid gap-3 grid-cols-4 sm:grid-cols-4 md:grid-cols-4 lg:grid-cols-4" >
    <div class="max-w-xs">
          <div class="bg-white shadow-xl rounded-lg py-3">
              <div class="photo-wrapper p-2">
                  <img class="w-32 h-32 rounded-full mx-auto" src="terminal.jpg" alt="terminal">
              </div>
              <h3 class="text-center text-xl text-gray-900 font-medium leading-8"> ALL </h3>
              <div class="p-2">
                  <h3 class="text-center text-xl text-gray-900 font-medium leading-8"> {{ $TotalTerminals }} </h3>

                  <table class="text-xm my-3">
                    <tbody>
                        <tr >
                          <td class="px-2 py-2 text-center">Status :</td>
                          <td class="px-2 py-2 text-center"><div class="w-12 mx-auto  text-gray-900 font-medium leading-8 rounded-md bg-green-200">{{ $ActiveTerminals }}</div></td>
                          <td class="px-2 py-2 text-center"><div class="w-12 mx-auto  text-gray-900 font-medium leading-8 rounded-md bg-red-200">{{ $NonActiveTerminals }}</div>   </td>
                        </tr>
                    </tbody>
                </table>
              </div>
          </div>
    </div>
    <div class="max-w-xs">
          <div class="bg-white shadow-xl rounded-lg py-3">
              <div class="photo-wrapper p-2">
                  <img class="w-32 h-32 rounded-full mx-auto" src="terminal.jpg" alt="terminal">
              </div>
              <h3 class="text-center text-xl text-gray-900 font-medium leading-8"> IN </h3>
              <div class="p-2">
                  <h3 class="text-center text-xl text-gray-900 font-medium leading-8"> {{ $TotalInTerminals }} </h3>

                  <table class="text-xm my-3">
                    <tbody>
                        <tr >
                          <td class="px-2 py-2 text-center">Status :</td>
                          <td class="px-2 py-2"><div class="w-12 mx-auto text-center text-gray-900 font-medium leading-8 rounded-md bg-green-200">{{ $ActiveInTerminals }}</div></td>
                          <td class="px-2 py-2"><div class="w-12 mx-auto text-center text-gray-900 font-medium leading-8 rounded-md bg-red-200">{{ $NonActiveInTerminals }}</div>   </td>
                        </tr>
                    </tbody>
                </table>
              </div>
          </div>
    </div>
    <div class="max-w-xs">
          <div class="bg-white shadow-xl rounded-lg py-3">
              <div class="photo-wrapper p-2">
                  <img class="w-32 h-32 rounded-full mx-auto" src="terminal.jpg" alt="terminal">
              </div>
              <h3 class="text-center text-xl text-gray-900 font-medium leading-8"> OUT </h3>
              <div class="p-2">
                  <h3 class="text-center text-xl text-gray-900 font-medium leading-8"> {{ $TotalOutTerminals }} </h3>

                  <table class="text-xm my-3">
                    <tbody>
                        <tr >
                          <td class="px-2 py-2 text-center">Status :</td>
                          <td class="px-2 py-2"><div class="w-12 mx-auto text-center text-gray-900 font-medium leading-8 rounded-md bg-green-200">{{ $ActiveOutTerminals }}</div></td>
                          <td class="px-2 py-2"><div class="w-12 mx-auto text-center text-gray-900 font-medium leading-8 rounded-md bg-red-200">{{ $NonActiveOutTerminals }}</div>   </td>
                        </tr>
                    </tbody>
                </table>
              </div>
          </div>
    </div>
    <div class=" pl-4  h-full flex flex-col">

      <div class="bg-orange-500 text-center text-white-900 font-bold  shadow border-b border-gray-300">Connection Failed
      </div>
      <style>
        #journal-scroll::-webkit-scrollbar {
                  width: 4px;
                  cursor: pointer;
                  background-color: rgba(229, 231, 235, var(--bg-opacity));*/

              }
              #journal-scroll::-webkit-scrollbar-track {
                  background-color: rgba(229, 231, 235, var(--bg-opacity));
                  cursor: pointer;
                  /*background: red;*/
              }
              #journal-scroll::-webkit-scrollbar-thumb {
                  cursor: pointer;
                  background-color: #a0aec0;
                  /*outline: 1px solid slategrey;*/
              }
      </style>
      <div class="w-full h-full overflow-auto shadow bg-white" id="journal-scroll">
        <table class="w-full">
          <tbody class="">
              @foreach ($NonActiveList as $machine)
              <tr class="relative text-sm transform scale-100 py-2 border-b-2 border-blue-100 cursor-default ">

                  <td class="px-2 py-2 whitespace-no-wrap">
                      <div class="leading-5 text-gray-900 font-medium">Name : {{ $machine->description}} </div>
                      <div class="leading-5 text-gray-900">IP Address : {{ $machine->ip_address}}</div>
                      <div class="leading-5 text-gray-900">Last Known : {{ $machine->lastactivity }}</div>
                  </td>

              </tr>
              @endforeach
            </tbody>
      </table>
      </div>

    </div>
  </div>

</div>
