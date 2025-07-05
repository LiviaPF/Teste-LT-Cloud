<?php

namespace App\Livewire;

use App\Models\Developer;
use App\Models\Skill;
use Flux\Flux;
use Livewire\Component;

class CreateDeveloper extends Component
{
    public $name, $email, $seniority;
    public $skills = []; // array com as skills a serem vinculadas
    public $availableSkills; // array com as skills disponíveis para seleção

    public function mount()
    {
        $this->availableSkills = Skill::all();
    }

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'seniority' => 'required|in:junior,mid,senior',
            'email' => 'required|email|max:255|unique:developers,email',
            'skills' => 'nullable|array',
        ];
    }

    public function save()
    {
        $this->validate();
        $developer = Developer::create([
            'name' => $this->name,
            'seniority' => $this->seniority,
            'email' => $this->email,
        ]);

        $developer->skills()->sync($this->skills ?: []);

        $this->reset();
        Flux::modal('create-developer')->close();
        session()->flash('success', 'Developer created!');
        $this->redirectRoute('developers', navigate: true);
    }

    public function render()
    {
        return view('livewire.create-developer', [
            'skills' => $this->availableSkills,
        ]);
    }
}
