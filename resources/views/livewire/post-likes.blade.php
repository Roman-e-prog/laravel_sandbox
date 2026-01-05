<div class="iconWrapper">
    <x-ri-thumb-up-fill class="icons" title="{{count($post->likes)}} likes until now" wire:click="like"/>
    <x-ri-thumb-down-fill class="icons" title="{{count($post->dislikes)}} dislikes until now" wire:click="dislike"/>
</div>
