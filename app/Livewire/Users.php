<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
class Users extends Component
{
     // Form fields
    public $prename, $lastname, $street, $housenumber, $postal_code, $town;
   
    public $userId;
    //mountdata on load
    public function mount($userId) 
    { 
        $this->userId = $userId; 
        $user = User::findOrFail($userId); 
        $this->prename = $user->prename; 
        $this->lastname = $user->lastname; 
        $this->street = $user->street; 
        $this->housenumber = $user->housenumber; 
        $this->postal_code = $user->postal_code; 
        $this->town = $user->town; 
    }
    //rules to validate
    protected $rules = [
        'prename' => 'nullable|string',
        'lastname' => 'nullable|string',
        'street' => 'nullable|string',
        'housenumber' => 'nullable|string',
        'postal_code' => 'nullable|string',
        'town' => 'nullable|string',

    ];
    
     public function updateUser(){
         $this->validate();

        $user = User::findOrfail($this->userId);

        $user->update([
        'prename' => $this->prename,
        'lastname' => $this->lastname,
        'street' => $this->street,
        'housenumber' => $this->housenumber,
        'postal_code' => $this->postal_code,
        'town' => $this->town,
        ]);
        $this->editForm = false;
        $this->dispatch('toast', message:'Your data was successfully updated', type:'success');
       
    }
   
    
    public function render()
    {
        return view('livewire.users');
    }
}
