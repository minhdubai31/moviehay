@if (session()->has('message'))
    <div class="fixed -top-5 left-1/2 transform -translate-x-1/2 rounded-full shadow-lg bg-orange-600 p-3 px-5 flash-message opacity-0 duration-150 ease-linear" >
        <p class="text-white">
            {{ session('message') }}
        </p>
    </div>
@endif

<style>
  @keyframes flashMessage {
    0% {
      opacity: 0;
    }
    5% {
      top: 10px;
      opacity: 1;
    }
    95% {
      top: 10px;
      opacity: 1;
    }
    100% {
      opacity: 0;
    }
  }
  .flash-message {
    animation: flashMessage 4s ease 1s;
  }
</style>
