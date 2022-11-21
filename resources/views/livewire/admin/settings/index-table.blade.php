<div class="flex flex-col gap-5">
    @foreach($settings as $settingGroup)
        <div>
            <h3 class="text-2xl text-black">{{ $settingGroup['title'] }}</h3>
            <div class="text-md text-gray-500">{!! $settingGroup['subtitle'] !!}</div>
            <ul class="mt-2 flex flex-col divide-y">
                @foreach($settingGroup['items'] as $setting)
                    <li class="flex justify-between items-center py-3">
                        <div>
                            <h4 class="text-lg text-gray-900">{{ $setting['title'] }}</h4>
                            <div class="text-sm text-gray-500">{!! $setting['subtitle'] !!}</div>
                        </div>
                        <div>
                            <label class="inline-flex relative items-center mr-5 cursor-pointer">
                                <input wire:model="{{ dot_to_varname($setting['setting']) }}" type="checkbox" class="sr-only peer">
                                <div wire:click="updateSetting('{{ dot_to_varname($setting['setting']) }}')" class="switch-div peer"></div>
                            </label>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    @endforeach
</div>
