<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="Programmierblog Deutsch, Programmieren für Ältere, Roman Armin Rostock, Programmieren für Anfänger">
    <title>Programmieren für Ü40</title>
    @vite('resources/css/app.scss')
    @vite('resources/css/navbar.scss')
    @vite('resources/css/mobile-navbar.scss')
    @vite('resources/css/home.scss')
    @vite('resources/css/register.scss')
    @vite('resources/css/login.scss')
    @vite('resources/css/about.scss')
    @vite('resources/css/forum.scss')
    @vite('resources/css/myAccount.scss')
    @vite('resources/css/create.scss')
    @vite('resources/css/edit.scss')
    @vite('resources/css/forumposts.scss')
    @vite('resources/css/postlikes.scss')
    @vite('resources/css/detail.scss')
    @vite('resources/css/blogarticles.scss')
    @vite('resources/css/adminmessages.scss')
    @vite('resources/css/dashboard-articles.scss')
    @vite('resources/js/app.js')

   
    @livewireStyles
    @toastifyCss

</head>
<body>
    <div class="navWrapper">
        <div class="deskTop">
            @include('components.navbar')
        </div>
        <div class="mobile">
            @include('components.mobile-navbar')
        </div>
   </div>

    <div class="container">
        @yield('content')
        @yield('footer')
    </div>
    <script>
    window.addEventListener('toastify', event => {
    toastify().error(event.detail.message);
});
</script>
<!-- Add this to the bottom of the file -->
 <script>
    function showLoginToast() {
        window.dispatchEvent(new CustomEvent('toastify', {
            detail: { message: "Bitte loggen Sie sich ein, um einen Post anzulegen." }
        }));
    }
</script>
{{-- Global validation --}}
<script>
document.addEventListener('DOMContentLoaded', () => {

    // Validate all required fields on blur
    document.querySelectorAll('input[required], textarea[required], select[required]').forEach(field => {
        field.addEventListener('blur', () => {
            if (!field.value.trim()) {
                Toastify({
                    text: `${field.name} is required`,
                    backgroundColor: "#f44336",
                    duration: 3000,
                    close: true,
                    gravity: "top",
                    position: "right",
                }).showToast();
            }
        });
    });

    // Email format validation
    document.querySelectorAll('input[type="email"]').forEach(field => {
        field.addEventListener('blur', () => {
            const value = field.value.trim();
            if (value && !value.match(/^[^\s@]+@[^\s@]+\.[^\s@]+$/)) {
                Toastify({
                    text: "Invalid email format",
                    backgroundColor: "#f44336",
                    duration: 3000,
                    close: true,
                    gravity: "top",
                    position: "right",
                }).showToast();
            }
        });
    });

});
</script>



@toastifyJs
@livewireScripts
<x-toast />
</body>
</html>