<div class="container mx-auto">
    <div class="">
        <h2 class="text-4xl mb-4">Domény</h2>
        <!--<editor-fold desc="SEARCH">-->
        <div class="flex min-w-full justify-between">
            <select wire:model="filter" id="filter" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-l-lg focus:ring-blue-500 focus:border-blue-500 block w-40 p-2.5">
                @foreach ($filters as $filterKey => $filterLabel)
                    <option value="{{ $filterKey }}">{{ $filterLabel }}</option>
                @endforeach
            </select>
            <div class="flex-1">
                <input wire:model.debounce.500ms="search" type="text" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-r-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Vyhledat...">
            </div>
        </div>

        <!--</editor-fold desc="SEARCH">-->

        <div class="pt-4 px-2 -mx-2 overflow-x-auto">
            <div class="table inline-block min-w-full shadow-md rounded-lg overflow-hidden">
                <table class="min-w-full leading-normal">
                    <thead>
                        <tr>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                <a class="cursor-pointer whitespace-nowrap" wire:click="orderBy('value')">
                                    Hodnota
                                    <x-sort-icon field="value" :orderBy="$orderBy" :sortAsc="$sortAsc"/>
                                </a>
                            </th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                <a class="cursor-pointer whitespace-nowrap" wire:click="orderBy('reason')">
                                    Důvod
                                    <x-sort-icon field="reason" :orderBy="$orderBy" :sortAsc="$sortAsc"/>
                                </a>
                            </th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                <a class="cursor-pointer whitespace-nowrap" wire:click="orderBy('created_at')">
                                    Vytvořeno
                                    <x-sort-icon field="created_at" :orderBy="$orderBy" :sortAsc="$sortAsc"/>
                                </a>
                            </th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                <a class="cursor-pointer whitespace-nowrap" wire:click="orderBy('active')">
                                    Aktivní
                                    <x-sort-icon field="active" :orderBy="$orderBy" :sortAsc="$sortAsc"/>
                                </a>
                            </th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-gray-700">
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data['data'] as $record)
                            <tr class="odd:bg-white even:bg-slate-50 hover:bg-blue-200/50">
                                <td class="px-5 py-3 border-b border-gray-200 text-sm">
                                    <p class="text-gray-900 whitespace-no-wrap">
                                        @if(is_array($record['value']))
                                        {{ implode(' – ', $record['value']) }}
                                        @else
                                        {{ $record['value'] }}
                                        @endif
                                    </p>
                                </td>
                                <td class="px-5 py-3 border-b border-gray-200 text-sm">
                                    <p class="text-gray-900 whitespace-no-wrap">{{ $record['reason'] }}</p>
                                </td>
                                <td class="px-5 py-3 border-b border-gray-200 text-sm">
                                    <p class="text-gray-900 whitespace-no-wrap">
                                        {{ \Carbon\Carbon::parse($record['created_at'])->format('d.m.Y') }}
                                    </p>
                                </td>
                                <td class="px-5 py-3 border-b border-gray-200 text-sm">
                                    <p class="text-gray-900 whitespace-no-wrap">{{ $record['active'] }}</p>
                                </td>
                                <td class="px-5 py-3 border-b border-gray-200 text-sm text-right">
                                    <div class="flex space-x-4 justify-end">
                                        <a class="btn btn-link p-0 cursor-pointer" title="Odstranit uživatele">
                                            <i class="fa-solid fa-trash-alt text-red-500 hover:text-red-700"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="p-5">
                                    <div class="flex w-full justify-center">Nenalezena žádná data</div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="flex justify-between gap-4 min-w-full mt-4">
            <select wire:model="pageLength" id="filter" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block">
                <option value="10">10</option>
                <option value="20">20</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
            <div class="">
                <x-simple-paginator :next-page="$data['next_page']" :prev-page="$data['prev_page']" />
            </div>
        </div>
    </div>
</div>
