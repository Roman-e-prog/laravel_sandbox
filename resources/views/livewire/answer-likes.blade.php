<div class="iconWrapper">
    <x-ri-thumb-up-fill class="icons" title="{{count($answer->likes)}} likes until now"  wire:click="like"/>
    <x-ri-thumb-down-fill class="icons" title="{{count($answer->dislikes)}} dislikes until now" wire:click="dislike"/>
</div>

