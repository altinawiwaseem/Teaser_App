<?php

namespace App\Livewire;

use App\Models\Teaser;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Action;

class TeaserForm extends Component
{
    use WithFileUploads;

    public $title;
    public $text;
    public $image;

    protected $messages = [
        'title.required' => 'Die Überschrift ist erforderlich.',
        'title.string' => 'Die Überschrift muss ein gültiger Text sein.',
        'title.max' => 'Die Überschrift darf nicht länger als 255 Zeichen sein.',
        'text.required' => 'Der Text ist erforderlich.',
        'text.string' => 'Der Text muss gültig sein.',
        'image.required' => 'Bitte wählen Sie ein Bild aus.',
        'image.image' => 'Die Datei muss ein gültiges Bild sein (JPG, PNG, GIF).',
        'image.max' => 'Das Bild ist zu groß. Die maximale Dateigröße beträgt 2MB.',
        'image.mimes' => 'Das Bild muss vom Typ JPG, PNG oder GIF sein.',
    ];

    #[Action]
    public function save()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'text' => 'required|string',
            'image' => 'required|image|mimes:jpeg,jpg,png,gif|max:2048',
        ]);

        try {
            $path = $this->image->store('teasers', 'public');

            Teaser::create([
                'title' => $this->title,
                'text' => $this->text,
                'image_path' => $path,
                'user_id' => Auth::id(),
            ]);

            $this->reset(['title', 'text', 'image']);
            $this->dispatch('teaserCreated');

            // Reset validation errors
            $this->resetValidation();

            // Success message
            session()->flash('success', 'Teaser wurde erfolgreich erstellt!');
        } catch (\Exception $e) {
            $this->addError('image', 'Fehler beim Hochladen des Bildes. Bitte versuchen Sie es erneut.');
        }
    }

    public function updatedImage()
    {
        // Clear any previous errors when a new image is selected
        $this->resetErrorBag('image');

        if ($this->image) {
            try {
                $this->validateOnly('image', [
                    'image' => 'image|mimes:jpeg,jpg,png,gif|max:2048',
                ]);
            } catch (\Illuminate\Validation\ValidationException $e) {

                throw $e;
            }
        }
    }

    public function render()
    {
        return view('livewire.teaser-form');
    }
}
