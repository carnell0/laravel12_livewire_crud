<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Note;
use Flux\Flux;

class Notes extends Component
{
    use WithPagination;
    public $noteId;

    public function render()
    {
        $notes = Note::orderBy('created_at', 'desc')->paginate(5);
        return view('livewire.notes', [
            'notes' => $notes,
        ]);
        //return view('livewire.notes');
    }

    public function edit($id)
    {
        $this->dispatch('edit-note', $id);
    }   
    public function delete($id)
    {
        $this->noteId = $id;
        Flux::modal('delete-note')->show();
    }

    public function deleteNote()
    {
        Note::find($this->noteId)->delete();
        Flux::modal('delete-note')->close();
        session()->flash('success', 'Note deleted successfully.');
        $this->redirectRoute('notes', navigate:true);
    }
}
