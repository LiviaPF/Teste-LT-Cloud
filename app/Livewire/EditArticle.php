<?php

namespace App\Livewire;

use App\Models\Article;
use App\Models\Developer;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditArticle extends Component
{
    use WithFileUploads;

    public $article;
    public $title;
    public $slug;
    public $content;
    public $image;
    public $developers = [];

    public function mount($id)
    {
        $this->article = Article::findOrFail($id);
        $this->title = $this->article->title;
        $this->slug = $this->article->slug;
        $this->content = $this->article->content;
        $this->developers = $this->article->developers->pluck('id')->toArray();
    }

    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:articles,slug,' . $this->article->id,
            'content' => 'required|text',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'developers' => 'required|array|min:1',
            'developers.*' => 'exists:developers,id',
        ];
    }

    public function save()
    {
        $this->validate();

        $imageData = $this->article->image;
        if ($this->image) {
            $imageData = base64_encode(file_get_contents($this->image->getRealPath()));
        }

        $this->article->update([
            'title' => $this->title,
            'slug' => Str::slug($this->slug),
            'content' => $this->content,
            'image' => $imageData,
        ]);

        $this->article->developers()->sync($this->developers);

        $this->reset();

        session()->flash('success', 'Article updated!');
        return redirect()->route('articles.index');
    }

    public function render()
    {
        $developers = Developer::all();
        return view('livewire.edit-article', compact('developers'));
    }
}
