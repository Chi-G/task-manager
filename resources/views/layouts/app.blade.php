<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Project & Task Management System</title>

    <meta name="author" content="Chijindu Nwokeohuru">
    <meta name="contact" content="chijindu.nwokeohuru@gmail.com">
    <meta name="description" content="A modern Laravel project and task management system with drag-and-drop, modal CRUD, search, and a beautiful Tailwind CSS UI. Built by Chijindu Nwokeohuru.">
    <meta name="keywords" content="Laravel, Task Manager, Project Management, Tailwind CSS, Toastr, Chijindu Nwokeohuru, AJAX, Drag and Drop">

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
</head>
<body class="bg-gray-100 font-sans">

    <div class="min-h-screen flex flex-col">
        @yield('content')
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        $(function() {
            @if(session('success'))
                toastr.success("{{ session('success') }}");
            @endif
            @if(session('error'))
                toastr.error("{{ session('error') }}");
            @endif
        });
    </script>
    @stack('scripts')
</body>
</html>
