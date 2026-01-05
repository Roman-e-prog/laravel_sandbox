<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Usermessage;
use App\Models\Adminmessage;
class Adminmessages extends Component
{

    public $usermessages = [];
    public $users = [];
    public $adressats = [];
    public $adminmessages = [];
    public $adminmessage;
    public $formMode = "create";
    public $editingAdminmessageId;
    public $showAdminQuill = false;


    public function finalizeSubmit()
{
    if ($this->formMode === 'create') {
        $this->createAdminmessage();
    } else {
        $this->updateAdminMessage();
    }
}
    protected $rules = [
        'adminmessage'=>'array|required'
    ];

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
    $this->dispatch('request-quill-content', field: 'adminmessage'); 
    // Tell Livewire to continue AFTER quill content arrives 
    $this->dispatch('finalize-submit'); }

     public function getAllUsers (){
         $this->users = User::all();
    }
    public function getAllAdminmessages (){
         $this->adminmessages = Adminmessage::all();
    }
    public function getAllUsermessages (){
         $this->usermessages = Usermessage::all();
    }
   
      public function mount() // on Mount I call loadArticles
    {
        $this->getAllUsermessages();
        $this->getAllUsers();
        $this->getAllAdminmessages();
    }

    public function setUser($userId, $username, $userMessageId)
{
    // Prevent duplicates
    foreach ($this->adressats as $a) {
        if ($a['userId'] === $userId) {
            return;
        }
    }

    $this->adressats[] = [
        'userId' => $userId,
        'username' => $username,
        'usermessage_id' =>$userMessageId
    ];
    $this->showAdminQuill = true;
    dump($this->adressats, 'adressats');
}
    
    public function createAdminmessage()
{
    $recipient = $this->adressats[0];
    try{
        $message = Adminmessage::create([
            'user_id'         => auth()->id(),
            'adminname'       => auth()->user()->username,
            'adminmessage'    => $this->adminmessage,
            'published_at'    => now(),
            'has_answered'    => true,
            'questioner_id'   => $recipient['userId'],
            'questioner_name' => $recipient['username'],
            'usermessage_id'  => $recipient['usermessage_id'],
        ]);
    } catch(\Throwable $e){
          logger()->error('Message create failed', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
        ]);
        $this->dispatch('toast', message: 'Das hat nicht geklappt.', type: 'error'); 
        return;
    }
    $this->dispatch('toast', message:'Adminmessage was successfully created', type:'success');
    $this->updateUsermessage($recipient['usermessage_id']);
    $this->resetForm(); 
    $this->adressats = []; 
    $this->showAdminQuill = false;
}

    public function updateUsermessage($id){
       $message = Usermessage::findOrFail($id); 
       $message->update([
            'is_answered' => true,
        ]);
    }
     public function editAdminmessage($id)
    {
        $message = Adminmessage::findOrFail($id);
        $this->editingAdminmessageId = $id;
        $this->formMode = 'edit';

        $this->adminmessage = json_decode($message->adminmessage, true);;
        $this->dispatch( 'quill-set-content', field: 'adminmessage', value: $this->adminmessage);
        $this->showAdminQuill = true;

    }

    public function updateAdminmessage()
    {
        $this->validate();
        $message = Adminmessage::findOrFail($this->editingAdminmessageId);
        dump($this, 'this');
        $message->update([
            'adminmessage' => json_encode($this->adminmessage),
        ]);

        $this->resetForm();
        $this->getAllAdminmessages();
        $this->getAllUsermessages();
        $this->getAllUsers();
        $this->dispatch('toast', message:'Adminmessage was successfully updated', type:'success');
    }

    public function deleteAdminmessage($id)
    {
        Adminmessage::findOrFail($id)->delete();
         $this->getAllAdminmessages();
        $this->getAllUsermessages();
        $this->getAllUsers();
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


    public function cancelEdit()
    {
        $this->resetForm();
    }

    private function resetForm()
    {
        $this->reset([
            'editingAdminmessageId', 'formMode',
            'adminmessage'
        ]);
        $this->formMode = 'create';
    }
    public function render() { 
    return view('livewire.adminmessages', [ 'showAdminQuill' => $this->showAdminQuill, ]); }
}
