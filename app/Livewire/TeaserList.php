<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Teaser;

class TeaserList extends Component
{
    protected $listeners = ['teaserCreated' => '$refresh'];

    public function render()
    {
        return view('livewire.teaser-list', [
            'teasers' => Teaser::latest()->get()
        ]);
    }
}
