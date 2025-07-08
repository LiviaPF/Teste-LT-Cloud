<?php

namespace App\Livewire;

use App\Models\Article;
use Flux\Flux;
use Livewire\Component;
use Livewire\WithPagination;

class Articles extends Component
{
    use WithPagination;

    public $articleId;
    public $searchQuery = null;

    public function edit($id)
    {
        $this->redirectRoute('articles.edit', ['id' => $id], navigate: true);
    }

    public function delete($id)
    {
        $this->articleId = $id;
        Flux::modal('delete-article')->show();
    }

    public function deleteArticle()
    {
        $article = Article::find($this->articleId)->delete();
        Flux::modal('delete-article')->close();
        session()->flash('success', 'Article deleted!');
        $this->redirectRoute('articles', navigate: true);
    }

    public function render()
    {
        $articles = Article::with('developers')
            ->where('title', 'like', '%' . $this->searchQuery . '%')
            ->orderBy('title')
            ->paginate(9);
        return view('livewire.articles', [
            'articles' => $articles
        ]);
    }
}
