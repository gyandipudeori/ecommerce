<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;
use Livewire\Attributes\Title;
use App\Helpers\CartManagement;


#[Title('Product Detail -GyandipuisCoding')]
class ProductDetailPage extends Component
{
    public $slug;
    public $quantity = 1;

    public function mount($slug){
        $this->slug = $slug;
    }

    public function increaseQty(){
        $this->quantity++;
    }

    public function decreaseQty(){
        if($this->quantity> 1){
            $this->quantity--;
        }
    }

    public function addToCart($product_id) {
        $result = CartManagement::addItemToCart($product_id);
        $this->dispatch('update-cart-count', total_count: $result['total_count']); // ✅ Fire event
      
    }
    public function render()
    {
        return view('livewire.product-detail-page',[
            'product'=> Product::where('slug',$this->slug)->firstOrFail(),
        ]);
    }
}
