<?php

namespace App\Livewire;

use App\Models\Teaser;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Livewire\Features\SupportRedirects\Redirector;

class TeaserEdit extends Component
{
    use WithFileUploads;

    public Teaser $teaser;
    public string $title;
    public string $text;
    public $image;
    public $tempImageUrl;

    protected $rules = [
        'title' => ['required', 'string', 'max:255'],
        'text' => ['required', 'string'],
        'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
    ];

    public function mount(Teaser $teaser): void
    {
        $this->teaser = $teaser;
        $this->title = $teaser->title;
        $this->text = $teaser->text;
    }

    public function updatedImage()
    {
        $this->validateOnly('image');
        $this->tempImageUrl = $this->image->temporaryUrl();
    }

    public function removeImage()
    {
        $this->reset('image', 'tempImageUrl');
    }

    public function update(): Redirector
    {
        $this->validate();

        $data = [
            'title' => $this->title,
            'text' => $this->text,
        ];

        if ($this->image) {
            $data['image_path'] = $this->image->store('teasers', 'public');

            if ($this->teaser->image_path) {
                try {
                    Storage::disk('public')->delete($this->teaser->image_path);
                } catch (\Throwable $e) {
                    logger()->error('Image delete failed: ' . $e->getMessage());
                }
            }
        }

        $this->teaser->update($data);

        session()->flash('success', 'Teaser erfolgreich aktualisiert.');
        return redirect()->route('home');
    }

    public function render()
    {
        return view('livewire.teaser-edit')->layout('layouts.app');
    }


    public function deleteTeaser()
    {
        if ($this->teaser->image_path) {
            Storage::disk('public')->delete($this->teaser->image_path);
        }

        $this->teaser->delete();

        session()->flash('message', 'Teaser erfolgreich gelöscht.');
        return redirect()->route('home');
    }
}
