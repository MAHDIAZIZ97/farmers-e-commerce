<?php

namespace App\Livewire\Partials;

use App\Helpers\CartManagement;
use Livewire\Component;
use Livewire\Attributes\On;

class Navbar extends Component
{

    public $total_count = 0;
    public function mount(){
        $cartItems = CartManagement::getCartItemsFromCookie();

        // Set the total count based on the number of cart items
        $this->total_count = is_array($cartItems) ? count($cartItems) : 0;

    }

    #[On('update-cart-count')]
    public function updateCartCount($total_count){
        $this->total_count  = $total_count;
    }
    public function render()
    {
        return view('livewire.partials.navbar');
    }
}
