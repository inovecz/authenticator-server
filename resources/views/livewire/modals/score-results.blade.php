<div class="rounded-lg border bg-white border-blue-300 overflow-hidden">
  <div class="text-lg text-blue-700 bg-blue-100 px-4 py-2 border-b border-blue-300 flex justify-between items-center">
    <div>Hodnoty výpočtu skóre</div>
    <a wire:click.prevent="cancel()" href="#"><i class="fas fa-times cursor-pointer"></i></a>
  </div>
  <div class="p-4">
    <div class="grid grid-cols-3 pl-2 text-gray-500 text-xs">
      <span>Kontrola</span><span>Dosažený počet bodů</span><span>Maximální počet bodů</span>
    </div>
    <div class="grid grid-cols-3 pl-2 text-xs text-gray-700 mt-2">
      <span class="text-lg">Heslo:</span><span class="text-lg">{{ $response['password']['score'] }} bodů</span><span class="text-lg">120 bodů</span>
      <span class="pl-2">Úniky:</span><span>{{ $response['password']['leaks'] }} bodů</span><span>20 bodů</span>
      <span class="pl-2">Délka:</span><span>{{ $response['password']['length'] }} bodů</span><span>20 bodů</span>
      <span class="pl-2">Komplexnost - čísla:</span><span>{{ $response['password']['complexity']['numbers'] }} bodů</span><span>20 bodů</span>
      <span class="pl-2">Komplexnost - písmena:</span><span>{{ $response['password']['complexity']['letters'] }} bodů</span><span>20 bodů</span>
      <span class="pl-2">Komplexnost - malá/velká:</span><span>{{ $response['password']['complexity']['mixed_case'] }} bodů</span><span>20 bodů</span>
      <span class="pl-2">Komplexnost - symboly:</span><span>{{ $response['password']['complexity']['symbols'] }} bodů</span><span>20 bodů</span>
    </div>
    <div class="grid grid-cols-3 pl-2 text-xs text-gray-700 mt-2">
      <span class="text-lg">Entita:</span><span class="text-lg">{{ $response['entity']['score'] }} bodů</span><span class="text-lg">180 bodů</span>
      <span class="pl-2">Chování uživatele:</span><span>{{ $response['entity']['ml_score'] }} bodů</span><span>100 bodů</span>
      <span class="pl-2">Uniklý e-mail:</span><span>{{ $response['entity']['leaks']['email'] }} bodů</span><span>20 bodů</span>
      <span class="pl-2">Uniklý telefon:</span><span>{{ $response['entity']['leaks']['phone'] }} bodů</span><span>20 bodů</span>
      <span class="pl-2">Dočasný email:</span><span>{{ $response['entity']['disposable_email'] }} bodů</span><span>20 bodů</span>
      <span class="pl-2">Blacklist:</span><span>{{ $response['entity']['blacklist'] }} bodů</span><span>20 bodů</span>
    </div>
    <div class="grid grid-cols-3 pl-2 text-xs text-gray-700 mt-2 mb-2">
      <span class="text-lg">Celkem:</span><span class="text-lg">{{ $response['password']['score'] + $response['entity']['score'] }} bodů</span><span class="text-lg">300 bodů</span>
    </div>
    <hr>
    <div class="grid grid-cols-3 pl-2 text-lg text-gray-900 font-bold mt-2">
      <span>Procentuálně:</span><span></span><span>{{ round($response['score'], 2) }}%</span>
    </div>
  </div>
</div>
