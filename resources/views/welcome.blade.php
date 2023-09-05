@extends('layouts.guest')

@section('content')
  <div class="flex items-center justify-center min-h-screen bg-transparent sm:items-center py-4 sm:pt-0">
    <div class="flex flex-col gap-8">
      <div class="flex items-center justify-center flex-col sm:flex-row gap-3 sm:gap-4">
        <span class="text-2xl sm:text-5xl text-gray-100 font-light">Authenticator Server</span>
      </div>
      <div class="relative flex flex-col sm:flex-row gap-4 backdrop-blur-lg bg-gray-500/30 border border-gray-200/30 rounded-xl px-8 sm:px-32 py-8 shadow-lg">
        <x-button :click="'Livewire.emit(\'openModal\', \'modals.authentication\', {\'action\': \'login\'})'" type="submit" button="primary" wide>Přihlášení</x-button>
        <x-button :click="'Livewire.emit(\'openModal\', \'modals.authentication\', {\'action\': \'register\'})'" type="submit" button="primary" wide>Registrace</x-button>
        <x-button :click="'Livewire.emit(\'openModal\', \'modals.authentication\', {\'action\': \'forgottenPassword\'})'" type="submit" button="secondary" wide>Zapomenuté heslo</x-button>
      </div>
    </div>
  </div>

  {{--<div class="fixed top-2 left-2 bg-white/50 p-2 text-xs z-20 border border-gray-600">
    <div class="text-red-800">Speed: <span class="text-gray-900 font-bold" id="speed">0</span> px/s</div>
    <div class="text-green-800">Max speed: <span class="text-gray-900 font-bold" id="max-speed">0</span> px/s</div>
    <div class="text-green-800">Avg speed: <span class="text-gray-900 font-bold" id="avg-speed">0</span> px/s</div>
    <div class="text-red-800">Acceleration: <span class="text-gray-900 font-bold" id="acceleration">0</span> px/s<sup>2</sup></div>
    <div class="text-green-800">Max acceleration: <span class="text-gray-900 font-bold" id="max-acceleration">0</span> px/s<sup>2</sup></div>
    <div class="text-green-800">Average acceleration: <span class="text-gray-900 font-bold" id="avg-acceleration">0</span> px/s<sup>2</sup></div>
    <div class="text-green-800">Total movement: <span class="text-gray-900 font-bold" id="total-movement">0</span> px</div>
    <div class="text-green-800 mt-2">Clicks: <span class="text-gray-900 font-bold" id="clicks">0</span></div>
    <div class="text-green-800">Selections: <span class="text-gray-900 font-bold" id="selections">0</span></div>
    <div class="text-green-800">Scrolls: <span class="text-gray-900 font-bold" id="scrolls">0</span></div>
    <div class="text-green-800 mt-2">Timer: <span class="text-gray-900 font-bold" id="timer">0</span> s</div>
  </div>--}}
@endsection

@push('scripts')
  <script>
      const startTime = new Date().getTime();
      let elapsedTime = 0;

      let windowBlurred = false;
      let currentEvent;
      let totalMovement = 0;
      let actualSpeed = 0, averageSpeed = 0, maxSpeed = 0, totalSpeed = 0;
      let actualAcceleration = 0, averageAcceleration = 0, maxAcceleration = 0, totalAcceleration = 0;
      let clickCounter = 0;
      let selectionCounter = 0;
      let scrollCounter = 0;
      let step = 0;
      let movingSteps = 0;

      document.addEventListener('mousemove', (event) => currentEvent = event);
      document.addEventListener('mousedown', () => clickCounter++);
      document.addEventListener('mouseup', () => {
          const selectedText = window.getSelection().toString();
          if (selectedText.length > 0) {
              selectionCounter++;
          }
      });
      document.addEventListener('scroll', () => scrollCounter++);
      document.addEventListener('mouseleave', () => windowBlurred = true);
      document.addEventListener('mouseenter', () => windowBlurred = false);
      window.addEventListener('blur', () => windowBlurred = true);
      window.addEventListener('focus', () => windowBlurred = false);

      setInterval(function () {
          if (!windowBlurred && currentEvent) {
              let movementX = currentEvent.movementX;
              let movementY = currentEvent.movementY;
              let movement = Math.round(Math.sqrt(movementX * movementX + movementY * movementY));

              totalMovement += movement;

              step++;
              if (movement >= 1) {
                  movingSteps++;
              }

              actualSpeed = 10 * movement;
              totalSpeed += actualSpeed;
              maxSpeed = actualSpeed > maxSpeed ? (maxSpeed = actualSpeed) : maxSpeed;
              averageSpeed = totalSpeed / movingSteps;

              actualAcceleration = 10 * actualSpeed;
              totalAcceleration += actualAcceleration;
              maxAcceleration = actualAcceleration > maxAcceleration ? (maxAcceleration = actualAcceleration) : maxAcceleration;
              averageAcceleration = totalAcceleration / movingSteps;

              /*document.getElementById('speed').innerText = Math.round(actualSpeed);
              document.getElementById('max-speed').innerText = Math.round(maxSpeed);
              document.getElementById('avg-speed').innerText = Math.round(averageSpeed);
              document.getElementById('acceleration').innerText = Math.round(actualAcceleration);
              document.getElementById('max-acceleration').innerText = Math.round(maxAcceleration);
              document.getElementById('avg-acceleration').innerText = Math.round(averageAcceleration);
              document.getElementById('total-movement').innerText = totalMovement;

              document.getElementById('clicks').innerText = clickCounter;
              document.getElementById('selections').innerText = selectionCounter;
              document.getElementById('scrolls').innerText = scrollCounter;*/
              currentEvent = undefined;
          } else {
              actualSpeed = actualAcceleration = 0;
              /* document.getElementById('speed').innerText = Math.round(actualSpeed);
               document.getElementById('acceleration').innerText = Math.round(actualAcceleration);*/
          }
      }, 100);

      setInterval(() => {
          elapsedTime = new Date().getTime() - startTime;
          const timerInput = document.getElementById('elapsedTime');
          const mouseMaxSpeedInput = document.getElementById('mouseMaxSpeed');
          const mouseAvgSpeedInput = document.getElementById('mouseAvgSpeed');
          const mouseMaxAccelInput = document.getElementById('mouseMaxAccel');
          const mouseAvgAccelInput = document.getElementById('mouseAvgAccel');
          const mouseMovementInput = document.getElementById('mouseMovement');
          const mouseClicksInput = document.getElementById('mouseClicks');
          const mouseSelectionsInput = document.getElementById('mouseSelections');
          const mouseScrollsInput = document.getElementById('mouseScrolls');
          if (timerInput && mouseMaxSpeedInput && mouseAvgSpeedInput && mouseMaxAccelInput && mouseAvgAccelInput && mouseMovementInput && mouseClicksInput && mouseSelectionsInput && mouseScrollsInput) {

              timerInput.value = elapsedTime / 1000;
              timerInput.dispatchEvent(new Event('change'));
              mouseMaxSpeedInput.value = Math.round(maxSpeed);
              mouseMaxSpeedInput.dispatchEvent(new Event('change'));
              mouseAvgSpeedInput.value = Math.round(averageSpeed);
              mouseAvgSpeedInput.dispatchEvent(new Event('change'));
              mouseMaxAccelInput.value = Math.round(maxAcceleration);
              mouseMaxAccelInput.dispatchEvent(new Event('change'));
              mouseAvgAccelInput.value = Math.round(averageAcceleration);
              mouseAvgAccelInput.dispatchEvent(new Event('change'));
              mouseMovementInput.value = totalMovement;
              mouseMovementInput.dispatchEvent(new Event('change'));
              mouseClicksInput.value = clickCounter;
              mouseClicksInput.dispatchEvent(new Event('change'));
              mouseSelectionsInput.value = selectionCounter;
              mouseSelectionsInput.dispatchEvent(new Event('change'));
              mouseScrollsInput.value = scrollCounter;
              mouseScrollsInput.dispatchEvent(new Event('change'));

          }
      }, 1);

      setInterval(() => {
          document.getElementById('timer').innerText = elapsedTime / 1000;
      }, 47);
  </script>
@endpush
