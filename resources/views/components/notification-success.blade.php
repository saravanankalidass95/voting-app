@props([
    'type' => 'success',
    'redirect' => false,
    'messageToDisplay' => '',
    ])

<div 
    x-cloak
    x-data="{ 
        isOpen: false,
        messageToDisplay: '{{ $messageToDisplay }}',
        showNotification(message){
            this.isOpen = true
            this.messageToDisplay = message
            setTimeout(() => {
                this.isOpen = false
            }, 3000)
        }
    }"
    x-init="
        @if ($redirect)
            $nextTick(() => showNotification(messageToDisplay))
        @else
            Livewire.on('ideaWasUpdated', message => {
                showNotification(message)
            })

            Livewire.on('ideaWasMarkedAsSpam', message => {
                showNotification(message)
            })

            Livewire.on('ideaWasMarkedAsNotSpam', message => {
                showNotification(message)
            })

            Livewire.on('statusWasUpdated', message => {
                showNotification(message)
            })

            Livewire.on('commentWasAdded', message => {
                showNotification(message)
            })

            Livewire.on('commentWasUpdated', message => {
                showNotification(message)
            })

            Livewire.on('commentWasDeleted', message => {
                showNotification(message)
            })

            Livewire.on('commentWasMarkedAsSpam', message => {
                showNotification(message)
            })

            Livewire.on('commentWasMarkedAsNotSpam', message => {
                showNotification(message)
            })
        @endif

    "
    x-show="isOpen"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 transform translate-x-8"
    x-transition:enter-end="opacity-100 transform translate-x-0"
    x-transition:leave="transition ease-in duration-300"
    x-transition:leave-start="opacity-100 transform translate-x-0"
    x-transition:leave-end="opacity-0 transform translate-x-8"
    @keydown.escape.window="isOpen = false"
    
    
    class="z-30 flex justify-between max-w-xs sm:max-w-sm w-full fixed bottom-0 right-0 bg-white rounded-xl shadow-lg border px-4 py-5 mx-2 sm:mx-6 my-8"
>
    <div class="flex items-center">
        @if($type == 'success')
            <svg class="text-green h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11.35 3.836c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m8.9-4.414c.376.023.75.05 1.124.08 1.131.094 1.976 1.057 1.976 2.192V16.5A2.25 2.25 0 0118 18.75h-2.25m-7.5-10.5H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V18.75m-7.5-10.5h6.375c.621 0 1.125.504 1.125 1.125v9.375m-8.25-3l1.5 1.5 3-3.75" />
            </svg>
        @endif
        @if($type == 'error')
            <svg class="text-red h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
            </svg>
        @endif
        <div class=" font-semibold text-gray-500 text-small sm:text-base ml-2" x-text="messageToDisplay"></div>
    </div>
    <button @click="isOpen = false"  class="text-gray-400 hover:text-gray-500">
        <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
        </svg>
    </button>
</div>
