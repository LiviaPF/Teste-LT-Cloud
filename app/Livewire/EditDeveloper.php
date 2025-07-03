<?php

namespace App\Livewire;

use App\Models\Developer;
use Flux\Flux;
use Livewire\Attributes\On;
use Livewire\Component;

class EditDeveloper extends Component
{
    public $name, $email, $seniority, $developerId;

    #[On('edit-developer')]
    public function editDeveloper($id)
    {
        $developer = Developer::findOrFail($id);
        $this->developerId = $developer->id;
        $this->name = $developer->name;
        $this->email = $developer->email;
        $this->seniority = $developer->seniority;
        Flux::modal('edit-developer')->show();
    }

    public function update()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'seniority' => 'required|in:junior,mid,senior',
        ]);

        $developer = Developer::find($this->developerId);
        $developer->name = $this->name;
        $developer->email = $this->email;
        $developer->seniority = $this->seniority;
        $developer->save();

        session()->flash('success', 'Developer updated successfully.');
        $this->redirectRoute('developers', navigate: true);
        Flux::modal('edit-developer')->close();
    }

    public function render()
    {
        return view('livewire.edit-developer');
    }
}
