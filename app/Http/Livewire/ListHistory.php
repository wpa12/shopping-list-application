<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\ListModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ListHistory extends Component
{
    public $lists = null;
    public $user;
    public $list_model;
    public $current_user;

    protected $listeners = [
        'list_created' => 'find_lists_for_current_user',
        'delete_list' => 'delete_list',
        'update_list_after_deletion' => 'update_history',
    ];

    public function mount(ListModel $list): void  
    {
        $this->list_model = $list;
        $this->current_user = Auth::user();
        $this->find_lists_for_current_user(Auth::user()->id);    
    }

    public function find_lists_for_current_user ($user_id): void
    {
        $this->lists = ListModel::where('user_id', $user_id)->get();
    }

    public function delete_list ($list_id): void
    {
        $item = ListModel::find($list_id);
        
        $this->emitTo(ShoppingList::class, 'list_deleted', $list_id);

        $item->delete();
        
        $this->emitSelf('update_list_after_deletion', $this->current_user->id);
    }

    public function update_history(): void 
    {
        $this->find_lists_for_current_user($this->current_user->id);
    }

    public function selected_list($list_id): void 
    {
        $this->emitTo(ShoppingList::class, 'selected_list', $list_id);
    }

    public function render(): View
    {
        return view('livewire.list-history');
    }
}
