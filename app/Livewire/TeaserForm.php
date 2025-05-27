<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Teaser;

class TeaserForm extends Component
{
    use WithFileUploads;

    public $title;
    public $text;
    public $image;

    protected $rules = [
        'title' => 'required|string|max:255',
        'text' => 'required|string',
        'image' => 'required|image|max:2048', // 2MB
    ];

    public function submit()
    {
        $this->validate();

        $path = $this->image->store('teasers', 'public');

        Teaser::create([
            'title' => $this->title,
            'text' => $this->text,
            'image_path' => $path,
            'user_id' => auth()->id() ?? null,
        ]);

        $this->reset(['title', 'text', 'image']);

        $this->emit('teaserAdded');

        // Show success message
        session()->flash('message', 'Teaser created successfully!');
    }

    public function render()
    {
        return view('livewire.teaser-form');
    }
}
