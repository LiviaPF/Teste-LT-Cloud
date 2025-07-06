<?php

namespace App\Livewire;

use App\Models\Developer;
use App\Models\Skill;
use Flux\Flux;
use Livewire\Attributes\On;
use Livewire\Component;

class EditDeveloper extends Component
{
    public $name, $email, $seniority, $developerId, $bindedDeveloper;

    public $skills; // contém as skills a serem vinculadas
    public $availableSkills; // contém as skills disponíveis para seleção

    public function mount()
    {
        $this->availableSkills = Skill::all();
        $this->skills = collect();
    }

    #[On('edit-developer')]
    public function editDeveloper($id)
    {
        $developer = Developer::findOrFail($id);
        $this->developerId = $developer->id;
        $this->name = $developer->name;
        $this->email = $developer->email;
        $this->seniority = $developer->seniority;
        $this->skills = $developer->skills;
        $this->bindedDeveloper = $developer;
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
        $developer->skills()->sync($this->skills ?: []);

        $developer->save();

        session()->flash('success', 'Developer updated!');
        $this->redirectRoute('developers', navigate: true);
        Flux::modal('edit-developer')->close();
    }

    public function isBinded($selectedSkill)
    {
        foreach ($this->skills as $skill) {
            if ($skill['id'] == $selectedSkill) {
                return true;
            }
        }
        return false;
    }

    public function updateSkills($selectedSkillId, $isSelected)
    {
        // se a skill tiver sido deselecionada, remove-a do array de skills
        if (!$isSelected) {
            $this->skills = $this->skills->filter(function ($skill) use ($selectedSkillId) {
                return $skill['id'] != $selectedSkillId;
            });
            return;
        }
        // se a skill tiver sido selecionada, adiciona-a ao array de skills
        $newSkillObject = Skill::find($selectedSkillId);
        $this->skills->push($newSkillObject);
    }

    public function render()
    {
        return view('livewire.edit-developer', [
            'skills' => $this->availableSkills,
        ]);
    }
}
