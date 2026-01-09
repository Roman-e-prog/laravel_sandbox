<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Blogarticle;
use App\Models\BlogarticleImages;
class DashboardArticles extends Component
{
    use WithFileUploads;

    public $articles = [];//fetch Array for articles
    public $editingArticleId = null; // fetch for ArticleId
    public $formMode = 'create'; //default create

    // Form fields
    public $title, $ressort, $unit, $description, $article_content;
    public $tasks = [];
    public $external_links = [];
    public $images = [];

    public function finalizeSubmit()
{
    if ($this->formMode === 'create') {
        $this->createArticle();
    } else {
        $this->updateArticle();
    }
}


    protected $listeners = [ 
        'quill-content' => 'setQuillContent', 
        'finalize-submit' => 'finalizeSubmit', ];

    public function setQuillContent($field, $value)
{
    if (!$field) return;
    $decoded = json_decode($value, true);
    if ($decoded === null) {
        $decoded = ['ops' => [['insert' => "\n"]]];
    }

    $this->$field = $decoded;
}

    // Ask browser for the quill content
    public function submitForm() { // Ask browser for quill content 
    $this->dispatch('request-quill-content', field: 'article_content'); 
    // Tell Livewire to continue AFTER quill content arrives 
    $this->dispatch('finalize-submit'); }

    protected $rules = [ // validation
        'title' => 'required|string|min:1',
        'ressort' => 'required|string|min:1',
        'unit' => 'required|string|min:1',
        'description' => 'required|string|min:1',
        'article_content' => 'required|array|min:1',
        'tasks' => 'nullable|array',
        'external_links' => 'nullable|array',
        'images.*.path' => 'nullable|image|max:1024',
        'images.*.title' => 'nullable|string',
        'images.*.alt' => 'nullable|string',
    ];
    public function mount() // on Mount I call loadArticles
    {
        abort_unless(auth()->user()?->role === 'admin', 403);
        $this->loadArticles();
    }

    public function loadArticles()
    {
        $this->articles = Blogarticle::with('images')->get(); //all Articles are fetched and set into the fetchArray
    }
    //images
    public function addImage() // my add button for images
    {
        $this->images[] = ['path' => null, 'title' => '', 'alt' => '']; 
    }

    public function removeImage($index) // my removeButton for images
    {
        unset($this->images[$index]);
        $this->images = array_values($this->images);
    }
    //tasks
    public function addTask()
    {
        $this->tasks[] = ['task' => '', 'description' => ''];
    }

    public function removeTask($index)
    {
        unset($this->tasks[$index]);
        $this->tasks = array_values($this->tasks);
    }
    //links
     public function addLink()
    {
        $this->external_links[] = ['url' => '', 'label' => ''];
    }

    public function removeLink($index)
    {
         unset($this->external_links[$index]);
        $this->external_links = array_values($this->external_links);
    }

    public function createArticle()
    {
        try{
            $this->validate();//runs automatically the rules
         
        $article = Blogarticle::create([
            'title' => $this->title, 
            'ressort' => $this->ressort, 
            'unit' => $this->unit, 
            'description' => $this->description, 
            'article_content' => $this->article_content, 
            'tasks' => $this->tasks, 
            'external_links' => $this->external_links,
            'user_id' => auth()->id(),
            'author' => auth()->user()->username, 
            'published_at' => now(), 
        ]);
        foreach ($this->images as $image) {
            $path = $image['path'] ? $image['path']->store('images', 'public') : null;
            $article->images()->create([
                'path' => $path,
                'title' => $image['title'],
                'alt' => $image['alt'],
            ]);
        }
    } catch(\Throwable $e){
          logger()->error('Article create failed', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
        ]);
        $this->dispatch('toast', message:'Article not created', type:'error');
        return;
    }
      

        $this->resetForm();
        $this->dispatch('toast', message:'Article was successfully created', type:'success');
        $this->loadArticles();
    }

    public function editArticle($id)
    {
        $article = Blogarticle::with('images')->findOrFail($id);
        $this->editingArticleId = $id;
        $this->formMode = 'edit';

        $this->title = $article->title;
        $this->ressort = $article->ressort;
        $this->unit = $article->unit;
        $this->description = $article->description;
        $this->article_content = $article->article_content;
        $this->tasks = $article->tasks;
        $this->external_links = $article->external_links;
        $this->images = $article->images->map(fn($img) => [
            'id' => $img->id,
            'path' => null,
            'title' => $img->title,
            'alt' => $img->alt,
            'existing_path' => $img->path,
        ])->toArray();
        $this->dispatch( 'quill-set-content', field: 'article_content', value: json_encode($this->article_content) );

    }

    public function updateArticle()
    {
        $this->validate();
      
        $article = Blogarticle::findOrFail($this->editingArticleId);

        $article->update([
            'title' => $this->title,
            'ressort' => $this->ressort,
            'unit' => $this->unit,
            'description' => $this->description,
            'article_content' => $this->article_content,
            'tasks' => $this->tasks,
            'external_links' => $this->external_links,
        ]);

        foreach ($this->images as $image) {
            if (isset($image['id'])) {
                $existing = BlogarticleImages::find($image['id']);
                if ($existing) {
                    $existing->update([
                        'title' => $image['title'],
                        'alt' => $image['alt'],
                        'path' => $image['path'] instanceof \Livewire\TemporaryUploadedFile
                            ? $image['path']->store('images', 'public')
                            : $existing->path,
                    ]);
                }
            } else {
                $path = $image['path'] ? $image['path']->store('images', 'public') : null;
                $article->images()->create([
                    'path' => $path,
                    'title' => $image['title'],
                    'alt' => $image['alt'],
                ]);
            }
        }

        $this->resetForm();
        $this->dispatch('toast', message:'Article was successfully updated', type:'success');
        $this->loadArticles();
    }

    public function deleteArticle($id)
    {
        Blogarticle::findOrFail($id)->delete();
        $this->loadArticles();
    }

    public function cancelEdit()
    {
        $this->resetForm();
    }

    private function resetForm()
    {
        $this->reset([
            'editingArticleId', 'formMode',
            'title', 'ressort', 'unit', 'description', 'article_content',
            'tasks', 'external_links', 'images'
        ]);
        $this->formMode = 'create';
    }

    public function render()
    {
        return view('livewire.dashboard-articles');
    }
}
