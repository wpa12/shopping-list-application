<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\ListModel;
use Illuminate\Support\Facades\Auth;

class ListHistory extends Component
{
    public $lists = null;
    public $user;
    public $list_model;
    public $current_user;

    /**
     *Declare event listeners 
     */
    protected $listeners = [
        'list_created' => 'find_lists_for_current_user',
        'delete_list' => 'delete_list',
        'update_list_after_deletion' => 'update_history',
    ];

    public function mount(ListModel $list) {
        $this->list_model = $list;
        $this->current_user = Auth::user();
        $this->find_lists_for_current_user(Auth::user()->id);
    }


    /**
     * finds list for a current authenticated user
     * @param $user_id
     */
    public function find_lists_for_current_user ($user_id) {
        $this->lists = ListModel::where('user_id', $user_id)->get();
    }

    /**
     * Deletes a list
     * @param $list_id
     */
    public function delete_list ($list_id) {
        $item = ListModel::find($list_id);
        
        $this->emitTo(ShoppingList::class, 'list_deleted', $list_id);

        $item->delete();
        
        return $this->emitSelf('update_list_after_deletion', $this->current_user->id);
    }

    /**
     * Updates the history of lists to revisit
     */
    public function update_history() {
        return $this->find_lists_for_current_user($this->current_user->id);
    }


    /**
     * Emits an event to the ShoppingList component to update items for selected list
     */
    public function selected_list($list_id) {
        return $this->emitTo(ShoppingList::class, 'selected_list', $list_id);
    }

    public function render()
    {
        return view('livewire.list-history');
    }
}
