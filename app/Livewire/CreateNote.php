<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Note;
use Flux\Flux;

class CreateNote extends Component
{
    public $title;
    public $content;

    protected function rules()
    {
        return [
            'title' => 'required|string|unique:notes,title|max:255',
            'content' => 'required|string',
        ];
    }
    public function save()
    {
        $this->validate();
        //dd('ok');

        //store note
        Note::create([
            'title' => $this->title,
            'content' => $this->content,
        ]);
        //reset form
        $this->reset();
        //close create-modal
        Flux::modal('create-note')->close();

        //display flash message
        session()->flash('success', 'Note created successfully.');

        //redirect to notes route
        $this->redirectRoute('notes', navigate:true);


    }
    public function render()
    {
        return view('livewire.create-note');
    }
}
