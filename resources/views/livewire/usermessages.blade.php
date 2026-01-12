<form wire:submit.prevent="submitForm">
    @csrf
    @include('quill.container', ['field' => 'usermessage'])
    <input type="hidden" id="usermessage" name="usermessage" />
    <button type="submit" class="sendBtn">Absenden</button>
</form>
