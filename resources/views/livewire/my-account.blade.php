<div class="fullWrapper">
    @auth
    <div class="myData">
        <h2 class="datahead">Ihre Daten</h2>
        <h2 class="myName">{{auth()->user()->prename . ' ' . auth()->user()->lastname}}</h2>
        <p class="street">{{auth()->user()->street . ' ' . auth()->user()->housenumber}}</p>
        <p class="town">{{auth()->user()->postal_code . ' ' . auth()->user()->town}}</p>
        <p class="email">{{auth()->user()->email}}</p>
        <button wire:click="editUser({{ auth()->user()->id }})" class="editBtn">Ändern</button>
        <!-- Calls deleteArticle($id) in the component -->
        <button wire:click="handleDelete()" class="messageBtn">Blog verlassen oder Nachricht an Admin</button>
    </div>
     <div class="editUser">
        @if($editForm)
            <livewire:users :userId="auth()->user()->id"/>
            @endif
     </div>
     <div class="deleteUser">
        @if($deleteWarning)
            <div class="deleteWarning">
                <p class="warning">Account löschen oder Nachricht an den Admin.</p>
                @if($usermessageForm)
                    <livewire:usermessages :userId="auth()->user()->id" :username="auth()->user()->username"/>
                    @else
                    <div class="buttonWrapper">
                        <button class="backBtn" wire:click="closeDelete">Schließen</button>
                        <button class="messageBtn" wire:click="handleUserMessage">Nachricht an Admin</button>
                        <button class="deleteUserBtn" wire:click="deleteUser({{ auth()->user()->id }})">Löschen (Endgültig)</button>
                    </div>
                @endif
            </div>
        @endif
     </div>
     <div class="youHaveMessages">
        @if ($youHaveMessages)
            @foreach ($adminmessages as $adminmessage )
                <h3>Deine Nachrichten</h3>
                <div class="messagesWrapper">
                    <h3>Nachricht von : {{$adminmessage->adminname}}</h3>
                    <h4> Vom : {{$adminmessage->published_at}}</h4>
                    <p class="tableItem">{{ $this->decodeDelta($adminmessage->adminmessage) }}</p>
                </div>
            @endforeach
        @endif
     </div>
     <div class="youHavePosts">
        @if ($youHavePosts)
            @foreach ($myPosts as $myPost )
                <h3>Deine Forum Einträge</h3>
                <div class="fieldWrapper">
                    <a href="{{route('forumposts.detail', ['ressort'=>$myPost->ressort, 'id'=>$myPost->id])}}" class="link">
                        <h4> A post from: {{$myPost->username}}</h4>
                        <h4>Posted at {{$myPost->published_at->format('d.m.Y H:i')}}</h4>
                        <h3>{{ $myPost->title }}</h3>
                        <img src="{{ Storage::url($myPost->images_path) }}" alt="{{$myPost->title}}" class="postImage">
                        @php
                            $decoded = is_string($myPost->blog_post_body)
                                ? json_decode($myPost->blog_post_body, true)
                                : $myPost->blog_post_body;
                        @endphp
                        <x-quill-viewer :delta="$decoded" :id="$myPost->id" />
                        <p>{{$myPost->slug}}</p>
                   </a>
            @endforeach
        @endif
     </div>
     @endauth
</div>
