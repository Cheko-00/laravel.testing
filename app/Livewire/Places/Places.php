<?php

namespace App\Livewire\Places;

use Livewire\Component;

class Places extends Component
{
    public function render()
    {
        return view('livewire.places.places')->layout('layouts::app', ['title' => 'MyApp | Places List']); ;
    }
}
