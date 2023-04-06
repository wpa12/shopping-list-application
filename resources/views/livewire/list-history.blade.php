<div>
    @if(! empty($lists[0]))
    <ul class="menu bg-white w-auto p-2 rounded-box flex gap-5" x-transition>
        <li class="menu-title text-base-200">
            <span class="text-2xl">History of Lists</span><span>(click list name to make active list)</span>
        </li>
        @foreach($lists as $list)
        <li class="flex flex-row justify-between items-center w-auto gap-2"><button wire:click="selected_list('{{ $list->id }}')" class="flex-1 btn btn-outline">{{ $list->name ?? '' }}</button><button class="btn btn-error text-base-200 flex-1" wire:click="delete_list({{ $list->id }})">Delete list</button></li>
        @endforeach
    </ul>
    @endif
</div>