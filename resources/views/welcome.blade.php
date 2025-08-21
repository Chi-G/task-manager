<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Chijindu Nwokeohuru">
    <meta name="contact" content="chijindu.nwokeohuru@gmail.com">
    <meta name="description" content="A modern Laravel project and task management system with drag-and-drop, modal CRUD, search, and a beautiful Tailwind CSS UI. Built by Chijindu Nwokeohuru.">
    <meta name="keywords" content="Laravel, Task Manager, Project Management, Tailwind CSS, Toastr, Chijindu Nwokeohuru, AJAX, Drag and Drop">

    <title>Project & Task Management System</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#3f3d56] min-h-screen flex flex-col">

    <!-- navbar -->
    <header class="w-full bg-transparent py-6">
        <div class="container mx-auto px-6 lg:px-20 flex items-center justify-between">
            <!-- logo -->
            <div class="flex items-center space-x-2">
                <div class="bg-white text-purple-600 p-2 rounded-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 12h6m-3-3v6m9-6a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <span class="text-white font-bold text-xl">Task Manager</span>
            </div>

            <!-- nav links -->
            <nav class="hidden md:flex space-x-8 text-white font-medium">
                <a href="#" class="hover:text-gray-200">Home</a>
                <a href="#" class="hover:text-gray-200">Features</a>
                <a href="#" class="hover:text-gray-200">Demo</a>
                <a href="#" class="hover:text-gray-200">Projects</a>
                <a href="#" class="hover:text-gray-200">Tasks</a>
                <a href="#" class="hover:text-gray-200">About</a>
            </nav>

            <a href="#"
               class="bg-orange-500 text-white hidden md:inline-block px-5 py-2 rounded-lg shadow hover:bg-orange-600 transition">
                COALITION TECHNOLOGIES
            </a>
        </div>
    </header>

    <!-- hero section -->
    <main class="flex-1">
        <div class="container mx-auto px-6 lg:px-20 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div class="text-white space-y-6 pt-10">
                <h1 class="text-4xl lg:text-5xl font-extrabold leading-tight">
                    Streamline Your Projects & Tasks with Ease
                </h1>
                <p class="text-lg opacity-90 pt-8">
                    Empower your team to collaborate, prioritize, and deliver results. Our intuitive platform is designed for businesses of all
                    sizes. Helping you manage projects, assign tasks, and track progress in real time. Boost productivity, enhance
                    accountability, and keep every project on schedule.
                </p>
                <a href="{{ route('projects.index') }}"
                class="inline-block bg-white text-purple-600 font-semibold px-8 py-3 rounded-lg shadow hover:bg-gray-100 transition mt-16">
                    View Dashboard
                </a>
            </div>

            <div class="flex justify-center lg:justify-end pt-14">
                <img src="https://pixelwibes.com/template/my-task/marketing/assets/img/hero/hero-img.png"
                     alt="Dashboard Preview" class="rounded-xl shadow-2xl">
            </div>
        </div>
    </main>

</body>
</html>
