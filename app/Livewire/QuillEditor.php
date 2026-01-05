<?php

namespace App\Livewire;

use Livewire\Component;

class QuillEditor extends Component
{
    
    // public $field; 
    // public $value = '';    // dynamic field name
    // public $article_content = '';
    // public $usermessge = '';
    // public function mount($field, $value = '')
    // {
    //     $this->field = $field;
    //     $this->value = $value;
    //     if($field === 'article_content'){
    //         $this->article_content = $value;
    //     }
    //     else if($field === 'usermessage'){
    //         $this->usermessage = $value;
    //     }
         // optional: preload existing content
    // }
    // public function updatedContent($value) { When I want to use this build in function I have to use the varaible $content, but its obsolete when the browser event dispatches the custom function I catch in the parents class
    //     // bubble up to parent 
    //     $this->dispatch('quill-updated', field: $this->field, value: $value); 
    //     }
    // public function render()
    // {
    //     return view('livewire.quill-editor');
    // }
}
