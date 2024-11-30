<?php

namespace App\Livewire;

use App\Models\Season;
use App\Models\Category;
use Livewire\Attributes\Title;

use Livewire\Component;

#[Title('Homepage-LocalFarm')]
class HomePage extends Component
{
    public function render()
    {
        $season = Season::where('is_active',1)->get();
        $categories = Category::where('is_active',1)->get();
        // dd($season);
        return view('livewire.home-page',[
            'seasons' => $season,
            'categories' => $categories,
        ]);
    }
}
