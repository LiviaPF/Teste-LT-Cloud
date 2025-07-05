<?php

namespace App\Livewire;

use App\Models\Skill;
use Flux\Flux;
use Livewire\Attributes\On;
use Livewire\Component;

class EditSkill extends Component
{
    public $name, $skillId;

    #[On('edit-skill')]
    public function editSkill($id)
    {
        $skill = Skill::findOrFail($id);
        $this->skillId = $skill->id;
        $this->name = $skill->name;
        Flux::modal('edit-skill')->show();
    }

    public function update()
    {
        $this->validate([
            'name' => 'required|string|max:255',
        ]);

        $skill = Skill::find($this->skillId);
        $skill->name = $this->name;
        $skill->save();

        session()->flash('success', 'Skill updated!');
        $this->redirectRoute('skills', navigate: true);
        Flux::modal('edit-skill')->close();
    }

    public function render()
    {
        return view('livewire.edit-skill');
    }
}
