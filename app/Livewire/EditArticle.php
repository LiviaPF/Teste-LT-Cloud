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

class EditArticle extends Component
{
    use WithFileUploads;

    public $articleId, $title, $content, $image, $slug;
    public $developers = [];
    public $availableDevelopers;
    public $article;

    public function mount($id)
    {
        $this->article = Article::findOrFail($id);
        $this->articleId = $this->article->id;
        $this->title = $this->article->title;
        $this->slug = $this->article->slug;
        $this->content = $this->article->content;
        $this->image = null;
        $this->developers = $this->article->developers->pluck('id')->toArray();
        $this->availableDevelopers = Developer::all();
    }

    protected function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:articles,slug,' . $this->articleId,
            'content' => 'required|min:10|max:65000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'developers' => 'required|array|min:1',
            'developers.*' => 'exists:developers,id',
        ];
    }

    public function update()
    {
        try {
            $this->validate();

            $article = Article::findOrFail($this->articleId);

            $article->update([
                'title' => $this->title,
                'slug' => Str::slug($this->slug),
                'content' => $this->content,
                'image' => $this->image,
            ]);

            $article->developers()->sync($this->developers ?: []);

            $this->reset(['title', 'slug', 'content', 'image', 'developers']);

            session()->flash('success', 'Article updated!');
            $this->redirectRoute('articles', navigate: true);
        } catch (ValidationException $e) {
            Log::error('Validation failed in update method: ' . json_encode($e->errors()));
            session()->flash('error', 'Validation failed: ' . implode(', ', Arr::flatten($e->errors())));
        } catch (\Exception $e) {
            Log::error('Error in update method: ' . $e->getMessage());
            session()->flash('error', 'Failed to update article: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.edit-article', [
            'article' => $this->article,
            'availableDevelopers' => $this->availableDevelopers,
        ]);
    }
}
