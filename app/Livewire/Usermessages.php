<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Usermessage;
class Usermessages extends Component
{
    public $userId, $usermessage, $username;
   
    public function mount($userId, $username){
         $this->userId = $userId; 
        $this->username = $username;
        $this->usermessage = '';
    }
    protected $listeners = [
    'quill-content' => 'setQuillContent',
];

    public function setQuillContent($field, $value)
{
    $this->$field = $value;
    $this->createMessage();
}
public function submitForm()
{
    // Ask browser for the quill content
    $this->dispatch('request-quill-content', field: 'usermessage');
}

        
    protected $rules = [
        'userId'=>'required',
        'usermessage'=>'required|string',
        'username'=>'required|string',
    ];
    
     public function createMessage()
        {
            $this->validate();
            try{
            Usermessage::create([
                'user_id'=>$this->userId,
                'usermessage'=>$this->usermessage,
                'username'=>$this->username,
                'published_at' => now(),
            ]);
        } catch(\Throwable $e){
            logger()->error('Message create failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            $this->dispatch('toast', message:'Usermessage was not created', type:'error');
        }
        $this->dispatch('toast', message:'Usermessage was successfully created', type:'success');
    }
    
    public function render()
    {
        return view('livewire.usermessages');
    }
}
