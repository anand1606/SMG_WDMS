<x-slot name="header">

</x-slot>

<div>
    <div class="w-full flex pb-10">
        <div class="w-3/6 mx-1">
            <input wire:model.debounce.300ms="search" type="text" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"placeholder="Search transactions...">
        </div>
        <div class="w-1/6 relative mx-1">
            <select wire:model="orderBy" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-state">
                <option value="id">ID</option>
                <option value="empunqid">EmpCode</option>
                <option value="punchdate">PunchTime</option>
                <option value="ip_address">Terminal</option>
                <option value="veryfymode">Veryfication Mode</option>
                <option value="ioflg">In/Out</option>
                <option value="exported">Exported</option>
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
            <tr>

                <th class="px-4 py-2">EmpUnqID</th>
                <th class="px-4 py-2">PunchTime</th>
                <th class="px-4 py-2">In/Out</th>
                <th class="px-4 py-2">IpAdd</th>
                <th class="px-4 py-2">Verifiedby</th>
                <th class="px-4 py-2">Exported</th>

            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $transaction)
                <tr>

                  <td class="border px-4 py-2">{{ $transaction->empunqid }}</td>
                    <td class="border px-4 py-2">{{ $transaction->punchdate }}</td>
                    <td class="border px-4 py-2">{{ $transaction->ioflg }}</td>
                    <td class="border px-4 py-2">{{ $transaction->ip_address }}</td>
                    <td class="border px-4 py-2">{{ $transaction->verifymode }}</td>
                    <td class="border px-4 py-2">{{ $transaction->exported }}</td>

                </tr>
            @endforeach
        </tbody>
    </table>
    {!! $transactions->links() !!}
</div>
