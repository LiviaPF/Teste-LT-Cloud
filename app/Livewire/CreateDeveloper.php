<?php

namespace App\Livewire;

use App\Models\Developer;
use Flux\Flux;
use Livewire\Component;

class CreateDeveloper extends Component
{
    public $name, $email, $seniority;

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'seniority' => 'required|in:junior,mid,senior',
            'email' => 'required|email|max:255',
        ];
    }

    public function save()
    {
        $this->validate();
        // store developer
        Developer::create([
            'name' => $this->name,
            'seniority' => $this->seniority,
            'email' => $this->email,
        ]);

        // reset fields
        $this->reset();
        Flux::modal('create-developer')->close();

        // display success message
        session()->flash('success', 'Developer created successfully!');

        // redirect to developers page
        $this->redirectRoute('developers', navigate: true);
    }

    public function render()
    {
        return view('livewire.create-developer');
    }
}
