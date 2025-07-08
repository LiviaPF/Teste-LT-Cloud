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

    public $articleId, $title, $content, $image, $newImage, $slug;
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
        $this->developers = $this->article->developers->pluck('id')->toArray();
        $this->availableDevelopers = Developer::all();

        if ($this->article->image) {
            $this->image = 'data:' . finfo_buffer(finfo_open(), $this->article->image, FILEINFO_MIME_TYPE)
                . ';base64,' . base64_encode($this->article->image);
        }
    }

    protected function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'slug' => ['required', 'regex:/^[a-z]+(-[a-z]+)*$/'],
            'content' => 'required|min:10|max:65000',
            'newImage' => 'nullable|file|mimes:jpeg,png,jpg,gif|max:2048',
            'developers' => 'required|array|min:1',
            'developers.*' => 'exists:developers,id',
        ];
    }

    public function update()
    {
        try {
            $this->validate();

            $article = Article::findOrFail($this->articleId);

            $imageBytes = null;
            if ($this->newImage) {
                if (!$this->newImage->isValid()) {
                    Log::error('Invalid image file uploaded', [
                        'size' => $this->newImage->getSize(),
                        'mime' => $this->newImage->getMimeType(),
                        'error' => $this->newImage->getError(),
                        'path' => $this->newImage->getRealPath()
                    ]);
                    session()->flash('error', 'Invalid image file. Please upload a valid JPEG, PNG, JPG, or GIF file.');
                    return;
                }

                $fileSize = $this->newImage->getSize();
                if ($fileSize > 2 * 1024 * 1024) {
                    Log::error('Image file too large', ['size' => $fileSize]);
                    session()->flash('error', 'Image file is too large. Maximum size is 2MB.');
                    return;
                }

                $filePath = $this->newImage->getRealPath();
                if (!is_readable($filePath)) {
                    Log::error('Image file not readable', ['path' => $filePath]);
                    session()->flash('error', 'Cannot read the uploaded image file. Check file permissions.');
                    return;
                }

                try {
                    $imageBytes = file_get_contents($filePath);
                    if ($imageBytes === false) {
                        throw new \Exception('Failed to read image file');
                    }

                    // verifica o mime type
                    $mimeType = $this->newImage->getMimeType();
                    if ($mimeType === 'application/octet-stream') {
                        $finfo = finfo_open(FILEINFO_MIME_TYPE);
                        $mimeType = finfo_file($finfo, $filePath);
                        finfo_close($finfo);
                        if (!in_array($mimeType, ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'])) {
                            Log::error('Invalid MIME type detected', ['mime' => $mimeType]);
                            session()->flash('error', 'Invalid image format. Please use JPEG, PNG, JPG, or GIF.');
                            return;
                        }
                    }

                    Log::info('Image bytes read successfully', ['size' => $fileSize, 'mime' => $mimeType, 'path' => $filePath]);
                } catch (\Exception $e) {
                    Log::error('Image processing failed: ' . $e->getMessage(), ['size' => $fileSize, 'mime' => $this->newImage->getMimeType(), 'path' => $filePath]);
                    session()->flash('error', 'Failed to process image: ' . $e->getMessage());
                    return;
                }
            }

            $article->update([
                'title' => $this->title,
                'slug' => Str::slug($this->slug),
                'content' => $this->content,
                'image' => $imageBytes ?: $article->image,
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

    protected function messages()
    {
        return [
            'slug.required' => 'The slug field is required.',
            'slug.regex' => 'The slug must contain only lowercase letters, separated by hyphen (e.g.: my-example-article).',
        ];
    }

    public function updatedTitle()
    {
        $this->generateSlug();
    }

    public function generateSlug()
    {
        $this->slug = strtolower(preg_replace('/[^a-zA-Z]+/', '-', $this->title));
        $this->slug = trim($this->slug, '-');
    }

    public function updatedSlug()
    {
        $this->validateOnly('slug');
    }

    public function render()
    {
        return view('livewire.edit-article', [
            'article' => $this->article,
            'availableDevelopers' => $this->availableDevelopers,
        ]);
    }
}
