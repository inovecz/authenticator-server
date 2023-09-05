<div class="container mx-auto">
  <div class="">
    <h2 class="text-4xl mb-4">Pokusy o přihlášení</h2>
    <!--<editor-fold desc="SEARCH">-->
    <div class="flex min-w-full justify-between">
      <select wire:model="filter" id="filter" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-l-lg focus:ring-blue-500 focus:border-blue-500 block w-40 p-2.5">
        @foreach ($filters as $filterKey => $filterLabel)
          <option value="{{ $filterKey }}">{{ $filterLabel }}</option>
        @endforeach
      </select>
      <div class="flex-1 relative">
        <input wire:model.debounce.500ms="search" type="text" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-r-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Vyhledat...">
        <span class="{{ $search === '' ? 'hidden' : '' }} absolute top-1/2 -translate-y-1/2 right-3 text-gray-600 hover:text-gray-700 cursor-pointer" wire:click="$set('search', '')"><i class="fa-solid fa-xmark"></i></span>
      </div>
    </div>

    <!--</editor-fold desc="SEARCH">-->

    <div class="pt-4 px-2 -mx-2 overflow-x-auto">
      <div class="table inline-block min-w-full shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full leading-normal">
          <thead>
            <tr class="text-xs font-semibold uppercase tracking-wider text-gray-700">
              <th class="py-3 border-b-2 border-gray-200 bg-gray-100">
              </th>
              <th class="pr-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left">
                <a class="cursor-pointer whitespace-nowrap" wire:click="orderBy('entity')">
                  Entita
                  <x-sort-icon field="entity" :orderBy="$orderBy" :sortAsc="$sortAsc"/>
                </a>
              </th>
              <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left">
                <a class="cursor-pointer whitespace-nowrap" wire:click="orderBy('ip')">
                  IP adresa
                  <x-sort-icon field="ip" :orderBy="$orderBy" :sortAsc="$sortAsc"/>
                </a>
              </th>
              <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left">
                <a class="cursor-pointer whitespace-nowrap" wire:click="orderBy('device')">
                  Zařízení
                  <x-sort-icon field="device" :orderBy="$orderBy" :sortAsc="$sortAsc"/>
                </a>
              <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left">
                <a class="cursor-pointer whitespace-nowrap" wire:click="orderBy('os')">
                  Operační systém
                  <x-sort-icon field="os" :orderBy="$orderBy" :sortAsc="$sortAsc"/>
                </a>
              </th>
              <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left">
                <a class="cursor-pointer whitespace-nowrap" wire:click="orderBy('browser')">
                  Prohlížeč
                  <x-sort-icon field="browser" :orderBy="$orderBy" :sortAsc="$sortAsc"/>
                </a>
              </th>
              <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left">
                <a class="cursor-pointer whitespace-nowrap" wire:click="orderBy('user_agent')">
                  UA
                  <x-sort-icon field="user_agent" :orderBy="$orderBy" :sortAsc="$sortAsc"/>
                </a>
              </th>
              <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left">
                <a class="cursor-pointer whitespace-nowrap" wire:click="orderBy('response->score')">
                  Skóre
                  <x-sort-icon field="response->score" :orderBy="$orderBy" :sortAsc="$sortAsc"/>
                </a>
              </th>
              <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-right">
                <a class="cursor-pointer whitespace-nowrap" wire:click="orderBy('created_at')">
                  Čas
                  <x-sort-icon field="created_at" :orderBy="$orderBy" :sortAsc="$sortAsc"/>
                </a>
              </th>
            </tr>
          </thead>
          <tbody>
            @forelse($data['data'] as $record)
              <tr class="odd:bg-white even:bg-slate-50 hover:bg-blue-200/50">
                <td class="pl-2 py-3 border-b border-gray-200 text-sm">
                  @if($record['successful'] === true)
                    <x-led type="success"/>
                  @else
                    <x-led type="danger"/>
                  @endif
                </td>
                <td class="pl-2 pr-5 py-3 border-b border-gray-200 text-sm">
                  <a class="flex items-center" href="/admin/users?filter=all&search={{$record['entity']}}&orderBy=surname&sortAsc=false">
                    <img src="https://www.gravatar.com/avatar/{{ md5(strtolower($users->where('hash', $record['entity'])->first()?->getEmail() ?? 'Neznámý uživatel')) }}?s=32&d=retro" alt="">
                    <div class="ml-3 flex flex-col">
                      <div class="text-gray-900 whitespace-nowrap font-bold">{{ $users->where('hash', $record['entity'])->first()?->getFullName(true) ?? 'Neznámý uživatel' }}</div>
                      <div class="text-[8px] whitespace-nowrap text-gray-500">{{ $record['entity'] }}</div>
                    </div>
                  </a>
                </td>
                <td class="px-5 py-3 border-b border-gray-200 text-sm">
                  <p class="text-gray-900 whitespace-nowrap">{{ $record['ip'] }}</p>
                </td>
                <td class="px-5 py-3 border-b border-gray-200 text-sm">
                  <p class="text-gray-900 whitespace-nowrap">{{ $record['device'] }}</p>
                </td>
                <td class="px-5 py-3 border-b border-gray-200 text-sm">
                  <p class="text-gray-900 whitespace-nowrap">{{ $record['os'] }}</p>
                </td>
                <td class="px-5 py-3 border-b border-gray-200 text-sm">
                  <p class="text-gray-900 whitespace-nowrap">{{ $record['browser'] }}</p>
                </td>
                <td class="px-5 py-3 border-b border-gray-200 text-sm">
                  <p class="truncate w-32 text-gray-900" data-tippy-content="{{ $record['user_agent'] }}">{{ $record['user_agent'] }}</p>
                </td>
                <td class="px-5 py-3 border-b border-gray-200 text-sm">
                  @if(isset($record['response']['score']))
                    <p wire:click.prevent="$emit('openModal', 'modals.score-results', {{ json_encode(['response' => $record['response']]) }})"
                       class="text-gray-900 whitespace-nowrap cursor-pointer underline">
                      {{ round($record['response']['score'], 2) }}
                    </p>
                  @else
                    <p class="text-gray-900 whitespace-nowrap">N/A</p>
                  @endif
                </td>
                <td class="px-5 py-3 border-b border-gray-200 text-sm text-right">
                  <div class="flex space-x-4 justify-end">
                    {{ \Carbon\Carbon::parse($record['created_at'])->format('d.m.Y H:i:s') }}
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
        <x-simple-paginator :total="$data['total']" :next-page="$data['next_page']" :prev-page="$data['prev_page']"/>
      </div>
    </div>
  </div>
</div>