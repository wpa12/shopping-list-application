<?php

namespace App\Http\Livewire;

use App\Models\ListItem;
use Illuminate\Support\Facades\Http;
use Livewire\Component;
use App\Models\ListModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ShoppingList extends Component
{
    public array $list_items = [];
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
    
    
    public function mount(): string|null
    {

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
    
    public function hydrate(): void 
    {
        if(! is_null($this->active_list)) 
        $this->active_list_items = ListItem::where('list_id', $this->active_list->id)->get();
    }
    
    public function create_list(): void
    {
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
        $this->emitTo(ListHistory::class , 'list_created', [Auth::user()->id]);
    }
    
    public function update_active_list_on_list_delete(): void
    {
        $this->active_list = null;
        $this->active_list_items = null;
    }
    
    public static function add_product_price(float $price): float 
    {
        return floatval($price);
    }
    
    public function add_item(): void
    {
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
                'price' => self::add_product_price($prod_details[1] > 0 ?: 0),
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
    
    public function delete_item(int $item_id): void
    {
        $item = ListItem::find($item_id);
        $item->delete();
        $this->fetch_active_list_items($this->active_list->id);
    }
    
    public static function check_list_name_exists (string $list_name, int $user_id): bool|null
    {
        $name_exists = ListModel::where('name', $list_name)->where('user_id', $user_id)->first();
        
        if ($name_exists) {
            return true;
        } 
        return false;
    }
    
    public function sum_list_total(int $list_id): void
    {
        $shopping_total = DB::table('list_items')
        ->where('list_id', $list_id)
        ->where('deleted_at', null)
        ->sum('price');
        
        $this->shopping_list_total = $shopping_total;
    }
    
    public function tick_item(int $item_id): void 
    {
        $item = ListItem::find($item_id);
        
        if($item->purchased > 0) {
            $item->update([
                'purchased' => 0,
            ]);
            
            $this->fetch_active_list_items($this->active_list->id);
        } else {
            
            $item->update([
                'purchased' => 1,
            ]);
        }
        
        $this->fetch_active_list_items($this->active_list->id);
    }
    
    public function set_active_list (int $list_id): void
    {
        $this->active_list = ListModel::find($list_id);
        $this->fetch_active_list_items($list_id);
    }
    
    public function fetch_active_list_items (int $list_id): void 
    {
        $this->active_list_items = ListItem::where('list_id', $list_id)->get();
        $this->sum_list_total($list_id);
    }
    
    public function email_list(string $emailAddress): void
    {
        // add mailable functionality
    }
    
    public function set_spending_cap (): void
    {
        //
    }
    
    public function render(): View
    {
        return view('livewire.shopping-list');
    }
}
