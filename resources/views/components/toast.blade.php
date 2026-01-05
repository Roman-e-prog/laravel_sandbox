{{-- Universal Toastify Listener --}}

@if (session('success'))
<script>
    Toastify({
        text: "{{ session('success') }}",
        duration: 3000,
        close: true,
        gravity: "top",
        position: "right",
        backgroundColor: "#4CAF50",
    }).showToast();
</script>
@endif

@if (session('error'))
<script>
    Toastify({
        text: "{{ session('error') }}",
        duration: 3000,
        close: true,
        gravity: "top",
        position: "right",
        backgroundColor: "#f44336",
    }).showToast();
</script>
@endif

@if (session('warning'))
<script>
    Toastify({
        text: "{{ session('warning') }}",
        duration: 3000,
        close: true,
        gravity: "top",
        position: "right",
        backgroundColor: "#ff9800",
    }).showToast();
</script>
@endif

@if (session('info'))
<script>
    Toastify({
        text: "{{ session('info') }}",
        duration: 3000,
        close: true,
        gravity: "top",
        position: "right",
        backgroundColor: "#2196F3",
    }).showToast();
</script>
@endif

{{-- Livewire listener --}}
<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('toast', (data) => {
            Toastify({
                text: data.message,
                duration: 3000,
                close: true,
                gravity: "top",
                position: "right",
                backgroundColor: data.type === 'error' ? "#f44336" : "#4CAF50",
            }).showToast();
        });
    });
</script>
