<!-- <a href="{{ route('login') }}">
    <img src="https://www.gravatar.com/avatar/00000000000000000000000000000000?d=mp" alt="avatar" class="w-10 h-10 rounded-full">
</a> -->


<div x-data="{ isOpen: false }" class="relative">
    <button @click="
        isOpen = !isOpen
        if (isOpen) {
            Livewire.emit('getNotification')
        }
    ">
    <img src="https://www.gravatar.com/avatar/00000000000000000000000000000000?d=mp" alt="avatar" class="w-10 h-10 rounded-full">
        
    </button>
    
        <div class="absolute w-76 md:w-96 text-left text-gray-700 text-xs bg-white border shadow-dialog z-10 rounded-xl max-h-128 overflow-y-auto -right-40 md:-right-12"
            style="right: -46px"
            x-cloak
            x-show.transition.origin.top="isOpen"
            @click.away="isOpen = false"
            @keydown.window.escape="isOpen = false">
            
            <div class="w-full flex flex-col justify-between mx-2 md:mx-4">
                <div class="w-full flex flex-col justify-between mx-2 md:mx-4 px-5 py-3">
                    <span class="text-xl font-semibold mt-2 md:mt-0 py-3">Welcome!</span>
                    
                    <div class="font-semibold text-sm py-3">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        You are logged in!
                    </div>
                    <div class="card-body">
                        <div class="font-semibold text-sm py-3">
                            upload your profile picture in 
                            <a href="https://en.gravatar.com/" class="text-blue">gravatar</a>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
   
</div>
