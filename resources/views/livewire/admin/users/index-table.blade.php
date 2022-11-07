<div class="container mx-auto">
    <div class="">
        <h2 class="text-4xl mb-4">Uživatelé</h2>

        <!--<editor-fold desc="SEARCH">-->
        <div class="flex min-w-full justify-between">
            <select wire:model="filter" id="filter" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-l-lg focus:ring-blue-500 focus:border-blue-500 block w-40 p-2.5">
                @foreach ($filters as $filterKey => $filterLabel)
                    <option value="{{ $filterKey }}">{{ $filterLabel }}</option>
                @endforeach
            </select>
            <div class="flex-1">
                <input wire:model="search" type="text" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-r-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Vyhledat...">
            </div>
        </div>

        <!--</editor-fold desc="SEARCH">-->

        <div class="pt-4 px-2 -mx-2 overflow-x-auto">
            <div class="table inline-block min-w-full shadow-md rounded-lg overflow-hidden">
                <table class="min-w-full leading-normal">
                    <thead>
                        <tr>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                <a class="cursor-pointer whitespace-nowrap" wire:click="orderBy('fullname')">
                                    Uživatel
                                    <x-sort-icon field="fullname" :orderBy="$orderBy" :sortAsc="$sortAsc"/>
                                </a>
                            </th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                <a class="cursor-pointer whitespace-nowrap" wire:click="orderBy('email')">
                                    E-mail
                                    <x-sort-icon field="email" :orderBy="$orderBy" :sortAsc="$sortAsc"/>
                                </a>
                            </th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                <a class="cursor-pointer whitespace-nowrap" wire:click="orderBy('last_attemp_at')">
                                    Poslední přihlášení
                                    <x-sort-icon field="last_attemp_at" :orderBy="$orderBy" :sortAsc="$sortAsc"/>
                                </a>
                            </th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                <a class="cursor-pointer whitespace-nowrap" wire:click="orderBy('login_count')">
                                    Σ přihlášení
                                    <x-sort-icon field="login_count" :orderBy="$orderBy" :sortAsc="$sortAsc"/>
                                </a>
                            </th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                <a class="cursor-pointer whitespace-nowrap" wire:click="orderBy('average_score')">
                                    Ø skóre
                                    <x-sort-icon field="average_score" :orderBy="$orderBy" :sortAsc="$sortAsc"/>
                                </a>
                            </th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-gray-700">
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr class="odd:bg-white even:bg-slate-50 hover:bg-blue-200/50">
                                <td class="px-5 py-3 border-b border-gray-200 text-sm">
                                    <div class="flex items-center">
                                        <img src="https://www.gravatar.com/avatar/{{ md5(strtolower($user->getEmail())) }}?s=32&d=retro" alt="">

                                        <div class="ml-3 flex flex-col">
                                            <div class="text-gray-900 whitespace-no-wrap font-bold">{{ $user->getFullName(reverse: true) }}</div>
                                            <div class="text-[8px] whitespace-nowrap text-gray-500">{{$user->getHash()}}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-5 py-3 border-b border-gray-200 text-sm">
                                    <p class="text-gray-900 whitespace-no-wrap">{{ $user->getEmail() }}</p>
                                </td>
                                <td class="px-5 py-3 border-b border-gray-200 text-sm">
                                    <p class="text-gray-900 whitespace-no-wrap">
                                        {{ $user->getLastAttempAt()->format('d.m.Y') }}
                                        <br>
                                        <span class="text-gray-500 text-xs">{{ $user->getLastAttempAt()->format('H:i:s') }}</span>
                                    </p>
                                </td>
                                <td class="px-5 py-3 border-b border-gray-200 text-sm">
                                    <p class="text-gray-900 whitespace-no-wrap">{{ $user->getLoginCount() }}</p>
                                </td>
                                <td class="px-5 py-3 border-b border-gray-200 text-sm">
                                    <p class="text-gray-900 whitespace-no-wrap">{{ round($user->getAverageScore(), 1) }}</p>
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
            <div class="">{{ $users->onEachSide(2)->links() }}</div>
        </div>
    </div>
</div>
