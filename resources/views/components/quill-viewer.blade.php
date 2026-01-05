<div 
    id="viewer-{{ $id }}" 
    class="quill-viewer"
    style="min-height: 50px;"
></div>

<script>
(function waitForQuill() {
    // Quill not ready yet → try again shortly
    if (typeof window.Quill === 'undefined') {
        return setTimeout(waitForQuill, 50);
    }
    

    // Safe delta
    const delta = @json($delta ?? ['ops' => []]);
    console.log('Quill exists:', typeof Quill !== 'undefined');
console.log('Delta:', delta);
console.log('Delta.ops exists:', delta && delta.ops);
console.log('Viewer element:', document.querySelector('#viewer-{{ $id }}'));
    // Initialize viewer
    const quill = new window.Quill('#viewer-{{ $id }}', {
        readOnly: true,
        theme: 'bubble'
    });

    // Apply delta
    if (delta && delta.ops) {
        quill.setContents(delta);
    }
})();
</script>

