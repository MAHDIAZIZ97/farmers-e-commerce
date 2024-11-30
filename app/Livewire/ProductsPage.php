<?php

namespace App\Livewire;

use App\Helpers\CartManagement;
use App\Livewire\Partials\Navbar;
use App\Models\Category;
use App\Models\Product;
use App\Models\Season;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;


#[Title('ProductsPage-LocalFarm')]
class ProductsPage extends Component
{
    use WithPagination;
    use LivewireAlert;
    #[Url]
    public $selected_categories = [];

    #[Url]
    public $selected_seasons = [];

    #[Url]

    public $featured;

    #[Url]
    public $on_sale;
    #[Url]
    public $price_range = 500;

    public $sort = 'latest';

    public function addToCart($product_id){
        $total_count = CartManagement::addItemToCart($product_id);

        $this->dispatch('update-cart-count',total_count:$total_count)->to(Navbar::class);

        $this->alert('success','Product added successfully',[
            'position' => 'top-end',
            'timer' => 3000,
            'toast' => true,
            'icon' => 'success',
        ]);
    }
    public function render()
    {
        $productQuery = Product::query()->where('is_active', 1);

        if(!empty($this->selected_categories)){
            $productQuery->whereIn('category_id', $this->selected_categories);
        }

        if(!empty($this->selected_seasons)){
            $productQuery->whereIn('season_id', $this->selected_seasons);
        }

        if($this->featured){
            $productQuery->where('is_featured', 1);
        }

        if($this->on_sale){
            $productQuery->where('on_sale', 1);
        }
        if($this->price_range){
            $productQuery->whereBetween('price', [0, $this->price_range]);
        }

        if($this->sort == 'latest'){
            $productQuery->latest();
        }
        if($this->sort == 'price_asc'){
            $productQuery->orderBy('price', 'asc');
        }
        if($this->sort == 'price_desc'){
            $productQuery->orderBy('price', 'desc');
        }

        return view('livewire.products-page',[
            'products' => $productQuery->paginate(6),
            'seasons'=> Season::where('is_active', 1)->get(['id','name','slug']),
            'categories'=> Category::where('is_active', 1)->get(['id','name','slug']),
        ]);
    }
}
