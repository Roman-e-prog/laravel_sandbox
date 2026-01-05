<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Adminmessage;
use App\Models\Post;
class MyAccount extends Component
{
    public $editForm = false; 
    public $deleteWarning = false;
    public $usermessageForm = false;
    public $adminmessages = [];
    public $youHaveMessages = false;
    public $youHavePosts = false;
    public $myPosts = [];

      public function editUser($userId){
        $this->editForm = true;
        $this->userId = $userId;
        
    }
       public function handleUserMessage()
    {
        $this->usermessageForm = true;
       
    }
     public function handleDelete()
    {
        $this->deleteWarning = true;
    }
    public function closeDelete()
    {
        $this->deleteWarning = false;
    }
    public function deleteUser($id){
        $user = User::findOrfail($id)->delete();
        $this->deleteWarning = false;
    }
    public function mount()
    {
        $this->getMyAdminmessages();
        $this->getMyPosts();
    }
    public function getMyAdminmessages()
    {
        $recipientId = auth()->id();

        $this->adminmessages = Adminmessage::where('questioner_id', $recipientId)->get();

        $this->youHaveMessages = $this->adminmessages->isNotEmpty();
    }
    public function getMyPosts()
    {
        $recipientId = auth()->id();

        $this->myPosts = Post::where('user_id', $recipientId)->get();

        $this->youHavePosts = $this->myPosts->isNotEmpty();
    }
    public function decodeDelta($deltaJson)
    {
        $delta = json_decode($deltaJson, true);

        if (json_last_error() !== JSON_ERROR_NONE || !isset($delta['ops'])) {
            return '';
        }

        $plainText = '';

        foreach ($delta['ops'] as $op) {
            if (isset($op['insert']) && is_string($op['insert'])) {
                $plainText .= $op['insert'];
            }
        }

        return trim(str_replace("\r\n", "\n", $plainText));
    }

    public function render()
    {
        return view('livewire.my-account');
    }
}
