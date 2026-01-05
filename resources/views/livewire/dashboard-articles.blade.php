<div class="container-articles">
    <!-- Article List -->
    <h2>Articles</h2>
    <ul>
        @foreach($articles as $article)
            <li>
                <p class="article-title">{{ $article->title }}</p>
                <!-- Calls editArticle($id) in the component -->
                <button wire:click="editArticle({{ $article->id }})">Edit</button>
                <!-- Calls deleteArticle($id) in the component -->
                <button wire:click="deleteArticle({{ $article->id }})">Delete</button>
            </li>
        @endforeach
    </ul>

    <!-- Create/Edit Form -->
    <h2>{{ $formMode === 'create' ? 'Create Article' : 'Edit Article' }}</h2>

    <!-- wire:submit.prevent calls createArticle() or updateArticle() -->
    <form wire:submit.prevent="submitForm" class="form">
        
        <!-- Bound to $title in the component -->
        <div class="formGroup">
            <label class="label" for="title">Title</label>
            <input type="text" wire:model="title" placeholder="Title" required>
            @error('title') <span class="error">{{ $message }}</span> @enderror
        </div>
        <!-- Bound to $ressort -->
        <div class="formGroup">
            <lable class="label" for="ressort">Ressort</lable>
            <input type="text" wire:model="ressort" required>
            @error('ressort') <span class="error">{{ $message }}</span> @enderror
        </div>
        <!-- Bound to $unit -->
        <div class="formGroup">
            <label class="label" for="unit">Unterichtseinheit</label>
            <input type="text" wire:model="unit" required>
            @error('unit') <span class="error">{{ $message }}</span> @enderror
        </div>
        <!-- Bound to $description -->
        <div class="formGroup">
            <label class="label" for="description">Beschreibung - Kurz</label>
            <textarea wire:model="description" required></textarea>
            @error('description') <span class="error">{{ $message }}</span> @enderror
        </div>
        <!-- Modular Quill Editor -->
        <div class="formGroup">
            <h3>Artikel schreiben</h3>
                <div><p>editor is mounted above the form</p></div>
            @error('article_content') <span class="error">{{ $message }}</span> @enderror
        </div>
        <!-- External Links (inline array binding) -->
        <div class="formGroup">
            @foreach($external_links as $index => $link)
                <div class="formGroup">
                    <label  class="label">Link</label>
                    <input type="text" placeholder="URL" wire:model="external_links.{{ $index }}.url">
                    <label class="label" for="label">Lable</label>
                    <input type="text" placeholder="Label" wire:model="external_links.{{ $index }}.label">
                    <button type="button" wire:click="removeLink({{ $index }})" class="deleteBtn">Remove</button>
                </div>
            @endforeach
            <button type="button" wire:click="addLink" class="addBtn">Add Link</button>
        </div>

        <!-- Tasks (inline array binding) -->
        <div class="formGroup">
            @foreach($tasks as $index => $task)
                <div class="formGroup">
                    <label  class="label">Aufgabe</label>
                    <input type="text" placeholder="Task" wire:model="tasks.{{ $index }}.task">
                    <label  class="label">Beschreibung</label>
                    <textarea placeholder="Description" wire:model="tasks.{{ $index }}.description"></textarea>
                    <button type="button" wire:click="removeTask({{ $index }})" class="deleteBtn">Remove</button>
                </div>
            @endforeach
            <button type="button" wire:click="addTask" class="addBtn">Add Task</button>
        </div>
        @error('tasks') <span class="error">{{ $message }}</span> @enderror

        <!-- Images -->
        <div class="formGroup">
            @foreach($images as $index => $image)
                <div>
                    @if(isset($image['existing_path']))
                        <!-- existing_path comes from DB (BlogArticleImages.path), not Livewire temp storage -->
                        <img src="{{ asset('storage/'.$image['existing_path']) }}" width="100">
                    @endif

                    <!-- Bound to $images[$index]['path'] -->
                    <div class="formGroup">
                        <input type="file" wire:model="images.{{ $index }}.path">
                    </div>
                    <!-- Bound to $images[$index]['title'] -->
                    <div class="formGroup">
                        <label  class="label">Bildtitel</label>
                        <input type="text" wire:model="images.{{ $index }}.title" placeholder="Title">
                    </div>
                    <!-- Bound to $images[$index]['alt'] -->
                    <div class="formGroup">
                        <label  class="label">Alt</label>
                        <input type="text" wire:model="images.{{ $index }}.alt" placeholder="Alt">
                    </div>
                    <button type="button" wire:click="removeImage({{ $index }})" class="deleteBtn">Remove</button>
                </div>
            @endforeach
            <button type="button" wire:click="addImage" class="addBtn">Add Image</button>
            </div>
        <!-- Submit -->
        <div class="submitWrapper">
            <button type="submit" class="sendBtn">{{ $formMode === 'create' ? 'Create' : 'Update' }}</button>
            @if($formMode === 'edit')
                <button type="button" wire:click="cancelEdit">Cancel</button>
            @endif
        </div>
    </form>
</div>
