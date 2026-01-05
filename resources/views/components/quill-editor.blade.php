<div wire:ignore>
    <div 
        x-data="quillEditor({ field: '{{ $field }}' })"
        x-init="init()"
    >
        <div x-ref="editor" style="min-height: 300px;"></div>
    </div>
</div>

