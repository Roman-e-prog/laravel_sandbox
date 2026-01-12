<div>
    <button wire:click="accept" class="acceptBtn">
    @if($answer->has_answered)
        <x-heroicon-o-check-circle class="myIcons" style="color:green" title="This is the answer"/>
    @else
        <x-heroicon-o-check-circle class="myIcons" style="color:black" title="set this as answer"/>
    @endif
</button>
</div>
