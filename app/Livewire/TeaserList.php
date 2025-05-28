<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Teaser;

class TeaserList extends Component
{
    // Listen for teaser creation events to refresh list
    protected $listeners = ['teaserCreated' => '$refresh'];

    // Render component with latest teasers
    public function render()
    {
        return view('livewire.teaser-list', [
            'teasers' => Teaser::latest()->get()  // Fetch teasers ordered by latest
        ]);
    }
}
