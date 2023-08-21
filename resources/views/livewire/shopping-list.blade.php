<div class="h-full w-full justify-center items-center flex gap-[5rem] flex-wrap py-10">
    <div>
        @livewire('list-history')
    </div>
    <div class="flex gap-5 flex-col flex-wrap"> 
        <div class="card bg-base-200 shadow-xl h-full">
            <div class="card-body flex gap-5">
                <h2 class="card-title">Hello {{ Str::ucfirst(decrypt(Auth::user()->name)) . '!' }}</h2>
                <p>Add items, delete items, or simply tick them off your list below.</p>
                @if($active_list !== null)
                <h3 class="text-xl text-cyan-400">Shopping List Selected: {{ $active_list->name }}</h3>
                @endif
                <ul class="flex gap-5 flex-col bg-neutral rounded-lg p-5" style="max-height:250px; overflow:scroll;">
                    @if(!$active_list_items)
                    <li class="text-white text-center">Please select a list from history, or make a new list</li>
                    @endif
                    @if($active_list_items)
                    
                    @foreach($active_list_items as $list_item)
                    <li class="flex justify-stretch items-center">
                        <div class="flex-1">
                            <strong 
                                @if($list_item->purchased > 0) 
                                    style="text-decoration:line-through; font-style:italic; color:red;" 
                                @endif 
                                class="flex-wrap text-white"
                                >
                                {{ $list_item->name }}
                            </strong>
                        </div>
                        <div class="flex-1">£ {{ $list_item->price }}</div>
                        <div class="flex-1">
                            
                            <button wire:click="tick_item('{{ $list_item->id }}')" class="btn btn-success">
                                <img @if($list_item->purchased) src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/Pjxzdmcgdmlld0JveD0iMCAwIDMyIDMyIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjx0aXRsZS8+PGcgZGF0YS1uYW1lPSJMYXllciAyIiBpZD0iTGF5ZXJfMiI+PHBhdGggZD0iTTMxLDE4QTExLjczLDExLjczLDAsMCwwLDE5LjE4LDcuNTlINEw3LjI1LDNBMSwxLDAsMCwwLDcsMS41OWExLDEsMCwwLDAtMS4zOS4yNEwxLjE1LDguMDhhLjg3Ljg3LDAsMCwwLDAsMWw0LjQ3LDYuMjZBMSwxLDAsMCwwLDcuMjUsMTQuMkw0LDkuNTlIMTkuMThBOS43Myw5LjczLDAsMCwxLDI5LDE4LjQ0YTkuNTEsOS41MSwwLDAsMS05LjQ4LDEwLjE1SDJhMSwxLDAsMSwwLDAsMmgxNy41QTExLjUxLDExLjUxLDAsMCwwLDMxLDE4WiIvPjxwYXRoIGQ9Ik01LjYsMTUuNzcsMS4xMyw5LjUxYS45LjksMCwwLDEsMC0xTDUuNiwyLjIzQTEsMSwwLDAsMSw3LDJIN2ExLDEsMCwwLDEsLjIzLDEuNEwzLjIzLDlsNCw1LjZBMSwxLDAsMCwxLDcsMTZIN0ExLDEsMCwwLDEsNS42LDE1Ljc3WiIvPjxwYXRoIGQ9Ik0xOS4xNiw4SDJBMSwxLDAsMCwwLDEsOUgxYTEsMSwwLDAsMCwxLDFIMTkuMTZBOS43Myw5LjczLDAsMCwxLDI5LDE4Ljg1LDkuNTEsOS41MSwwLDAsMSwxOS41LDI5SDJhMSwxLDAsMCwwLTEsMUgxYTEsMSwwLDAsMCwxLDFIMTkuNUExMS41MSwxMS41MSwwLDAsMCwzMSwxOC4zOSwxMS43MiwxMS43MiwwLDAsMCwxOS4xNiw4WiIvPjwvZz48L3N2Zz4=" @else src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/Pjxzdmcgdmlld0JveD0iMCAwIDUxMiA1MTIiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PHBhdGggZD0iTTE3My44OTggNDM5LjQwNGwtMTY2LjQtMTY2LjRjLTkuOTk3LTkuOTk3LTkuOTk3LTI2LjIwNiAwLTM2LjIwNGwzNi4yMDMtMzYuMjA0YzkuOTk3LTkuOTk4IDI2LjIwNy05Ljk5OCAzNi4yMDQgMEwxOTIgMzEyLjY5IDQzMi4wOTUgNzIuNTk2YzkuOTk3LTkuOTk3IDI2LjIwNy05Ljk5NyAzNi4yMDQgMGwzNi4yMDMgMzYuMjA0YzkuOTk3IDkuOTk3IDkuOTk3IDI2LjIwNiAwIDM2LjIwNGwtMjk0LjQgMjk0LjQwMWMtOS45OTggOS45OTctMjYuMjA3IDkuOTk3LTM2LjIwNC0uMDAxeiIvPjwvc3ZnPg==" @endif alt="check Item" style="width:20px;" aria-label="Check item from the list">
                            </button>
                            <button wire:click="delete_item('{{ $list_item->id }}')" class="btn btn-error">
                                <img src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/Pjxzdmcgc3R5bGU9ImVuYWJsZS1iYWNrZ3JvdW5kOm5ldyAwIDAgMjQgMjQ7IiB2ZXJzaW9uPSIxLjEiIHZpZXdCb3g9IjAgMCAyNCAyNCIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayI+PGcgaWQ9ImluZm8iLz48ZyBpZD0iaWNvbnMiPjxwYXRoIGQ9Ik0xNC44LDEybDMuNi0zLjZjMC44LTAuOCwwLjgtMiwwLTIuOGMtMC44LTAuOC0yLTAuOC0yLjgsMEwxMiw5LjJMOC40LDUuNmMtMC44LTAuOC0yLTAuOC0yLjgsMCAgIGMtMC44LDAuOC0wLjgsMiwwLDIuOEw5LjIsMTJsLTMuNiwzLjZjLTAuOCwwLjgtMC44LDIsMCwyLjhDNiwxOC44LDYuNSwxOSw3LDE5czEtMC4yLDEuNC0wLjZsMy42LTMuNmwzLjYsMy42ICAgQzE2LDE4LjgsMTYuNSwxOSwxNywxOXMxLTAuMiwxLjQtMC42YzAuOC0wLjgsMC44LTIsMC0yLjhMMTQuOCwxMnoiIGlkPSJleGl0Ii8+PC9nPjwvc3ZnPg==" alt="Remove Item" style="width:20px;" aria-label="Remove item from the list">
                            </button>
                        </div>
                    </li>
                    @endforeach
                    @endif
                    <li>Shopping Total: £{{number_format($shopping_list_total, 2)}} </li>
                </ul>
                <div class="card-actions flex justify-center flex-col">
                    @if(isset($active_list))
                    <form wire:submit.prevent="add_item">
                        @csrf
                        <div class="flex gap-5">
                            <input 
                                type="text" 
                                name="product" 
                                placeholder="Type a product here" 
                                class="text-white input input-bordered" 
                                wire:model.lazy="product"
                            >
                            <button class="btn btn-success" style="user-select:none;">
                                <img src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/PjwhRE9DVFlQRSBzdmcgIFBVQkxJQyAnLS8vVzNDLy9EVEQgU1ZHIDEuMS8vRU4nICAnaHR0cDovL3d3dy53My5vcmcvR3JhcGhpY3MvU1ZHLzEuMS9EVEQvc3ZnMTEuZHRkJz48c3ZnIGhlaWdodD0iNTEycHgiIGlkPSJMYXllcl8xIiBzdHlsZT0iZW5hYmxlLWJhY2tncm91bmQ6bmV3IDAgMCA1MTIgNTEyOyIgdmVyc2lvbj0iMS4xIiB2aWV3Qm94PSIwIDAgNTEyIDUxMiIgd2lkdGg9IjUxMnB4IiB4bWw6c3BhY2U9InByZXNlcnZlIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIj48cG9seWdvbiBwb2ludHM9IjQ0OCwyMjQgMjg4LDIyNCAyODgsNjQgMjI0LDY0IDIyNCwyMjQgNjQsMjI0IDY0LDI4OCAyMjQsMjg4IDIyNCw0NDggMjg4LDQ0OCAyODgsMjg4IDQ0OCwyODggIi8+PC9zdmc+" alt="Add an item" style="width:20px;" aria-label="add an item">
                            </button>
                        </div>
                        <div class="mt-4">
                            <span class="text-red-400">
                                Note: to add a price to item, follow the item name with a '/{pice of item}'
                            </span>
                        </div>
                    </form>  
                    @endif
                    @if($active_list)
                    <h3 class="mt-10">Or, continue to create a new list.</h3>
                    @endif
                    <form wire:submit.prevent="create_list">
                        @csrf    
                        <div class="flex gap-5 flex-col">
                            <p class="text-cyan-300">
                                Please create a new list or select a list from the history panel.
                            </p>
                            <input 
                                type="text" 
                                class="input input-bordered" 
                                wire:model.lazy="list_name" 
                                placeholder="Type a list name here"
                            >
                            <button class="btn btn-primary">Create list</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
