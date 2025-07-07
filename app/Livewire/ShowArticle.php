<?php

namespace App\Livewire;

use App\Models\Article;
use Livewire\Component;

class ShowArticle extends Component
{
    public $article;

    public function mount($slug)
    {
        $this->article = Article::with('developers')->where('slug', $slug)->firstOrFail();
    }

    public function getImageSrcProperty()
    {
        if ($this->article->image) {
            $mime = finfo_buffer(finfo_open(), $this->article->image, FILEINFO_MIME_TYPE);
            return 'data:' . $mime . ';base64,' . base64_encode($this->article->image);
        }

        return null;
    }

    public function render()
    {
        return view('livewire.show-article', [
            'article' => $this->article,
        ]);
    }
}
