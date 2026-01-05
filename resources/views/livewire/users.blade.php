<div>
    <div class="updateData">
        <form wire:submit.prevent="updateUser" class="userForm" method="POST">
            @csrf
            @method('put')
            <div class="formGroup">
                <label class="label" for="prename">Vorname</label>
                <input type="text" wire:model="prename" placeholder="prename" required>
                @error('prename') <span class="error">{{ $message }}</span> @enderror
            </div>
            <div class="formGroup">
                <label class="label" for="lastname">Nachname</label>
                <input type="text" wire:model="lastname" placeholder="lastname" required>
                @error('lastname') <span class="error">{{ $message }}</span> @enderror
            </div>
            <div class="formGroup">
                <label class="label" for="street">Straße</label>
                <input type="text" wire:model="street" required>
                @error('street') <span class="error">{{ $message }}</span> @enderror
            </div>
            <div class="formGroup">
                <label class="label" for="housenumber">Hausnummer</label>
                <input type="text" wire:model="housenumber" required>
                @error('housenumber') <span class="error">{{ $message }}</span> @enderror
            </div>
            <div class="formGroup">
                <label class="label" for="postal_code">Postleitzahl</label>
                <input type="text" wire:model="postal_code" required>
                @error('postal_code') <span class="error">{{ $message }}</span> @enderror
            </div>
            <div class="formGroup">
                <label class="label" for="town">Stadt</label>
                <input type="text" wire:model="town" required>
                @error('town') <span class="error">{{ $message }}</span> @enderror
            </div>
        </form>
    </div>
</div>
