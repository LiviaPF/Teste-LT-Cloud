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

    public function delete($id)
    {
        $this->articleId = $id;
        Flux::modal('delete-article-' . $id)->show();
    }

    public function deleteArticle()
    {
        if ($this->articleId) {
            Article::findOrFail($this->articleId)->delete();
            $this->articleId = null;
            Flux::modal('delete-article-' . $this->articleId)->close();
            session()->flash('success', 'Article deleted!');
        }
    }

    public function render()
    {
        $articles = Article::with('developers')
            ->orderBy('title')
            ->paginate(9);
        return view('livewire.articles', [
            'articles' => $articles
        ]);
    }
}
