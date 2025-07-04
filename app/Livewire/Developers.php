<?php

namespace App\Livewire;

use App\Models\Developer;
use Flux\Flux;
use Livewire\Component;
use Livewire\WithPagination;

class Developers extends Component
{
    use WithPagination;

    public $developerId;

    public function render()
    {
        // Fetch developers with pagination
        $developers = Developer::orderBy('created_at', 'desc')->paginate(9);
        return view('livewire.developers', [
            'developers' => $developers
        ]);
    }

    public function edit($id)
    {
        $this->dispatch('edit-developer', $id);
    }

    public function delete($id)
    {
        $this->developerId = $id;
        Flux::modal('delete-developer')->show();
    }

    public function deleteDeveloper()
    {
        $developer = Developer::find($this->developerId)->delete();
        Flux::modal('delete-developer')->close();
        session()->flash('success', 'Developer deleted successfully!');
        $this->redirectRoute('developers', navigate: true);
    }
}
