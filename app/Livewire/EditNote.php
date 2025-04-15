<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\Note;
use Flux\Flux;
use Illuminate\Validation\Rule;

class EditNote extends Component
{
    public $title, $content, $noteId;

    #[On('edit-note')]
    public function edit($id)
    {
      //dd("edit-note received with ID : {$id}");
        $note = Note::findOrFail($id);
        $this->noteId = $id;
        $this->title = $note->title;
        $this->content = $note->content;
        Flux::modal('edit-note')->show();
    }
    public function update()
    {
        $this->validate([
            'title' => ['required', 'string', 'max:255', Rule::unique('notes', 'title')->ignore($this->noteId)],
            'content' => 'required|string',
        ]);

        // Update the note
        $note = Note::find($this->noteId);
        $note->title = $this->title;
        $note->content = $this->content;
        // Save the note
        $note->save();

        // Reset the form
        $this->reset();

        // Close the modal
        Flux::modal('edit-note')->close();

        // Display flash message
        session()->flash('success', 'Note updated successfully.');

        // Redirect to notes route
        $this->redirectRoute('notes', navigate:true);
        Flux::modal('edit-note')->close();
    }
    public function delete()
    {
        $note = Note::findOrFail($this->noteId);
        $note->delete();

        // Reset the form
        $this->reset();

        // Close the modal
        Flux::modal('edit-note')->close();

        // Display flash message
        session()->flash('message', 'Note deleted successfully.');

        // Redirect to notes route
        $this->redirectRoute('notes', navigate:true);
    }
    public function render()
    {
        return view('livewire.edit-note');
    }
}
