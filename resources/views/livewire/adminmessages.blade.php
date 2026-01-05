<div class="container-adminmessage">
    <div class="userswrapper">
    <h2 class="usersheader">Alle Nutzer</h2>
    <ul class="userlist">
    @foreach ($users as $user)
        <li class="userItem">
            <div class="clickable" wire:click="setUser({{ $user->id }}, '{{ $user->username }}')">
            <p class="tableItem">{{$user->prename}}</p>
            <p class="tableItem">{{$user->lastname}}</p>
            <p class="tableItem">{{$user->username}}</p>
            <p class="taleItem">{{$user->id}}</p>
            <p class="tableItem">{{$user->email}}</p>
            <p class="tableItem">{{$user->town}}</p>
            </div>
            <p class="delete" wire:click="deleteUser({{$user->id}})">Delete</p>
        </li>
    @endforeach
    </ul>
    </div>
    <div class="usermessageswrapper">
    <h2 class="usermessagesHeader">Alle Nutzernachrichten</h2>
    <ul class="userlist">
    @foreach ($usermessages as $usermessage)
    @if (!$usermessage->is_answered)
        <li class="userMessagesItem">
            <div class="clickable" wire:click="setUser({{ $usermessage->user_id }}, '{{ $usermessage->username }}', {{$usermessage->id}})">
            <p class="tableItem">{{$usermessage->username}}</p>
            <p class="tableItem">{{$usermessage->published_at}}</p>
            <p class="tableItem">{{$usermessage->user_id}}</p>
            <p class="tableItem">{{ $this->decodeDelta($usermessage->usermessage) }}</p>
            @if ($usermessage->is_answered)
                <p>Beantwortet</p>
            @endif
            </div>
            <p class="delete" wire:click="deleteMessage({{$usermessage->id}})">Delete</p>
        </li>
    @endif
    @endforeach
    </ul>
    </div>
    <div class="adressats">
    <h3 class="usermessagesHeader">Adressaten:</h3>

    @foreach ($adressats as $a)
        <span class="badge">{{ $a['username'] }}</span>
    @endforeach
</div>
    <!-- Create/Edit Form -->
    <h2 class="usermessagesHeader">{{ $formMode === 'create' ? 'Create Message' : 'Edit Message' }}</h2>

    <!-- wire:submit.prevent calls createArticle() or updateArticle() -->
    <form wire:submit.prevent="submitForm" class="form">
        <!-- Submit -->
        <div class="submitWrapper">
            @if ($showAdminQuill)
                @include('quill.container', ['field' => 'adminmessage'])
            @endif
            <button type="submit" class="sendBtn">{{ $formMode === 'create' ? 'Create' : 'Update' }}</button>
            @if($formMode === 'edit')
                <button type="button" wire:click="cancelEdit">Cancel</button>
            @endif
        </div>
    </form>
    <div class="adminMessages">
        <div class="adminmessageswrapper">
    <h2 class="usermessagesHeader">Alle Adminnachrichten</h2>
    <ul class="adminmessagelist">
    @foreach ($adminmessages as $adminmessage)
        <li class="adminmessagesItem">
            <div class="adminmessage">
            <p class="tableItem">{{$adminmessage->has_answered}}</p>
            <p class="tableItem">{{$adminmessage->published_at}}</p>
            <p class="tableItem">{{$adminmessage->adminname}}</p>
            <p class="tableItem">{{$adminmessage->usermessage_id}}</p>
            <p class="tableItem">{{$adminmessage->questioner_name}}</p>
            <p class="tableItem">{{ $this->decodeDelta($adminmessage->adminmessage) }}</p>
            </div>
            <p class="delete" wire:click="deleteAdminmessage({{$adminmessage->id}})">Delete</p>
            <p class="update" wire:click="editAdminmessage({{$adminmessage->id}})">Update</p>
        </li>
    @endforeach
    </ul>
    </div>
</div>
