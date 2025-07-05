<?php

namespace App\Livewire;

use App\Models\Skill;
use Flux\Flux;
use Livewire\Component;

class CreateSkill extends Component
{
    public $name;

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
        ];
    }

    public function save()
    {
        $this->validate();
        Skill::create([
            'name' => $this->name,
        ]);

        // reset fields
        $this->reset();
        Flux::modal('create-skill')->close();

        // display success message
        session()->flash('success', 'Skill created!');

        // redirect to skills page
        $this->redirectRoute('skills', navigate: true);
    }

    public function render()
    {
        return view('livewire.create-skill');
    }
}
