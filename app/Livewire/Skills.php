<?php

namespace App\Livewire;

use App\Models\Skill;
use Livewire\Component;
use Livewire\WithPagination;

class Skills extends Component
{
    use WithPagination;

    public function render()
    {
        $skills = Skill::orderBy('created_at', 'desc')->paginate(15);
        return view('livewire.skills', [
            'skills' => $skills
        ]);
    }
}
