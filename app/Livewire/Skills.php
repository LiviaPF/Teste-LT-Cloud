<?php

namespace App\Livewire;

use App\Models\Skill;
use Flux\Flux;
use Livewire\Component;
use Livewire\WithPagination;

class Skills extends Component
{
    use WithPagination;

    public $skillId;

    public function render()
    {
        $skills = Skill::orderBy('created_at', 'desc')->paginate(15);
        return view('livewire.skills', [
            'skills' => $skills
        ]);
    }

    public function edit($id)
    {
        $this->dispatch('edit-skill', $id);
    }

    public function delete($id)
    {
        $this->skillId = $id;
        Flux::modal('delete-skill')->show();
    }

    public function deleteSkill()
    {
        $skill = Skill::find($this->skillId)->delete();
        Flux::modal('delete-skill')->close();
        session()->flash('success', 'Skill deleted!');
        $this->redirectRoute('skills', navigate: true);
    }
}
