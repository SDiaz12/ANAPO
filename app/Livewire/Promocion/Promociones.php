<?php

namespace App\Livewire\Promocion;

use Livewire\Attributes\Lazy;
use Livewire\Component;
//#[Lazy()]
class Promociones extends Component
{
    public function placeholder()
    {
        return view('livewire.Placeholder.loader')->layout('layouts.app');
    }
    public function render()
    {
        return view('livewire.promocion.promociones')->layout('layouts.app');
    }
}
