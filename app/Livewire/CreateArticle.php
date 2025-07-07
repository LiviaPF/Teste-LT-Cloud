<?php

namespace App\Livewire;

use App\Models\Article;
use App\Models\Developer;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateArticle extends Component
{
    use WithFileUploads;

    public $title, $image, $content;
    public $developers = [];
    public $availableDevelopers;

    public function mount()
    {
        $this->availableDevelopers = Developer::all();
    }

    protected function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'content' => 'required|min:10|max:65000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'developers' => 'required|array|min:1',
            'developers.*' => 'exists:developers,id',
        ];
    }

    public function save()
    {
        try {
            $this->validate();

            $article = Article::create([
                'title' => $this->title,
                'slug' => Str::slug($this->title),
                'content' => $this->content,
                'image' => $this->image,
            ]);

            $article->developers()->sync($this->developers ?: []);

            $this->reset();

            session()->flash('success', 'Article created!');
            $this->redirectRoute('articles', navigate: true);
        } catch (ValidationException $e) {
            Log::error('Validation failed in save method: ' . json_encode($e->errors()));
            session()->flash('error', 'Validation failed: ' . implode(', ', Arr::flatten($e->errors())));
        } catch (\Exception $e) {
            Log::error('Error in save method: ' . $e->getMessage());
            session()->flash('error', 'Failed to create article: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.create-article', [
            'availableDevelopers' => $this->availableDevelopers,
        ]);
    }
}
