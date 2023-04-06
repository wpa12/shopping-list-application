<?php

namespace App\Http\Livewire;

use App\Models\ListItem;
use Illuminate\Support\Facades\Http;
use Livewire\Component;
use App\Models\ListModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

use Money\Currency;
use Money\Money;

class ShoppingList extends Component
{
    public $list_items = [];
    public string|null $product = null;
    public string $list_name;
    public object|null $active_list = null;
    public object|null $active_list_items = null;

    public float $shopping_list_total = 0.00;
    public static float $spending_cap = 0.00;

    protected $listeners = [
        'selected_list' => 'set_active_list',
        'list_deleted' => 'update_active_list_on_list_delete',
    ];
    
    /**
     * Runs when the livewire component is mounted to the page (replacement for __construct)
     */
    public function mount() {
       // Try and send a get request to the tescolabs api, DNS won't resolve and postman and web browser * don't work either
        $tesco_header = [
            'Ocp-Apim-Subscription-Key'=> config('tesco_api_key'),
        ];

        try {
            $this->product = Http::withHeaders($tesco_header)->get('https://dev.tescolabs.com/grocery/products');
        
        } catch (\Exception $e) {
            return 'Tesco API is not currently working';
        }
    }

    /**
     * Hydrate function to reload component on change
     */
    public function hydrate() {
        if(! is_null($this->active_list)) 
            $this->active_list_items = ListItem::where('list_id', $this->active_list->id)->get();
    }


    /**
     * Create new shopping List and checks for existing list name
     */
    public function create_list() {

        if(empty($this->list_name)){
            return;    
        }

        if(self::check_list_name_exists($this->list_name, Auth::user()->id)) {
            return;
        }

        ListModel::create([
            'name' => $this->list_name,
            'user_id' => Auth::user()->id,
            'created_at' => Date::now(),
        ]);

        $this->active_list = ListModel::where('user_id', Auth::user()->id)->latest()->first();

        $this->active_list_items = ListItem::where('list_id', $this->active_list->id)->get();

        $this->list_name = '';

        return $this->emitTo(ListHistory::class , 'list_created', [Auth::user()->id]);
    }


    /**
     * update active list after a list is deleted
     */
    public function update_active_list_on_list_delete() {
        $this->active_list = null;
        $this->active_list_items = null;
    }


    /**
     * Add a price to an item in the list based on input
     */
    public static function add_product_price($price) {
        return floatval($price);
    }


    /**
     * Add an item to a selected list
     */
     public function add_item() {
        $prod_details = explode('/', $this->product);

        if($this->active_list_items->contains(function($key, $val) use ($prod_details) {
            return $key->name === $prod_details[0];

        }) || (empty($prod_details[0]) )) {
            $this->product = null;
            return;
        }

        if(sizeof($prod_details) > 1) {
            ListItem::create([
                'name' => $prod_details[0],
                'price' => self::add_product_price($prod_details[1]),
                'list_id' => $this->active_list->id,
            ]);
        } else {
            ListItem::create([
                'name' => $prod_details[0],
                'list_id' => $this->active_list->id,
            ]);
        }
        
        $this->product = null;
        $this->fetch_active_list_items($this->active_list->id);
     }


     /**
      * Delete and item
      * @param $item_id
      */
     public function delete_item($item_id) {
        $item = ListItem::find($item_id);
        $item->delete();
        return $this->fetch_active_list_items($this->active_list->id);
     }


    /**
     * function to check if a list name is already taken
     * @param $list_name, $user_id
     */
    public static function check_list_name_exists ($list_name, $user_id) {
        $name_exists = ListModel::where('name', $list_name)->where('user_id', $user_id)->first();
        if ($name_exists){
            return true;
        } 
    }

    /**
     * Sum the list of item prices
     * @param $list_id
     */
    public function sum_list_total($list_id) {
        $shopping_total = DB::table('list_items')
                                    ->where('list_id', $list_id)
                                    ->where('deleted_at', null)
                                    ->sum('price');

        $this->shopping_list_total = number_format($shopping_total,3);
    }

    /**
     * Tick Item off list
     */
     public function tick_item($item_id) {
        $item = ListItem::find($item_id);

        if($item->purchased > 0) {
            $item->update([
                'purchased' => 0,
            ]);
            return $this->fetch_active_list_items($this->active_list->id);
        } else {

            $item->update([
                'purchased' => 1,
            ]);
        }
        return $this->fetch_active_list_items($this->active_list->id);

     }


     /**
      * Set the active list that the user has selected from the history
      */
     public function set_active_list ($list_id) {
        $this->active_list = ListModel::find($list_id);
        $this->fetch_active_list_items($list_id);
     }

    
     /**
      * fetch active list items for an active list
      */
     public function fetch_active_list_items ($list_id) {
        $this->active_list_items = ListItem::where('list_id', $list_id)->get();
        $this->sum_list_total($list_id);
     }

    /**
     * Email the list of a user to the email they registered an account with.
     */
    public function email_list() {
        //
    }


    public function render()
    {
        return view('livewire.shopping-list');
    }
}
