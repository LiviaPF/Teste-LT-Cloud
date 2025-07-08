<?php

namespace App\Livewire;

use App\Models\Article;
use App\Models\Developer;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Arr;

class CreateArticle extends Component
{
    use WithFileUploads;

    public $title, $image, $content, $slug;
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
            'slug' => ['required', 'regex:/^[a-z]+(-[a-z]+)*$/'],
            'image' => 'nullable|file|mimes:jpeg,png,jpg,gif|max:2048',
            'developers' => 'required|array|min:1',
            'developers.*' => 'exists:developers,id',
        ];
    }

    protected function messages()
    {
        return [
            'slug.required' => 'The slug field is required.',
            'slug.regex' => 'The slug must contain only lowercase letters, separated by hyphen (e.g.: my-example-article).',
        ];
    }

    public function generateSlug()
    {
        $this->slug = strtolower(preg_replace('/[^a-zA-Z]+/', '-', $this->title));
        $this->slug = trim($this->slug, '-');
    }

    public function updatedTitle()
    {
        $this->generateSlug();
    }

    public function updatedSlug()
    {
        $this->validateOnly('slug');
    }

    public function save()
    {
        try {
            $this->validate();

            $imageBytes = null;
            if ($this->image) {
                if (!$this->image->isValid()) {
                    Log::error('Invalid image file uploaded', [
                        'size' => $this->image->getSize(),
                        'mime' => $this->image->getMimeType(),
                        'error' => $this->image->getError(),
                        'path' => $this->image->getRealPath()
                    ]);
                    session()->flash('error', 'Invalid image file. Please upload a valid JPEG, PNG, JPG, or GIF file.');
                    return;
                }

                $fileSize = $this->image->getSize();
                if ($fileSize > 2 * 1024 * 1024) {
                    Log::error('Image file too large', ['size' => $fileSize]);
                    session()->flash('error', 'Image file is too large. Maximum size is 2MB.');
                    return;
                }

                $filePath = $this->image->getRealPath();
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
                    $mimeType = $this->image->getMimeType();
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
                    Log::error('Image processing failed: ' . $e->getMessage(), ['size' => $fileSize, 'mime' => $this->image->getMimeType(), 'path' => $filePath]);
                    session()->flash('error', 'Failed to process image: ' . $e->getMessage());
                    return;
                }
            }

            $article = Article::create([
                'title' => $this->title,
                'slug' => Str::slug($this->slug),
                'content' => $this->content,
                'image' => $imageBytes,
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
