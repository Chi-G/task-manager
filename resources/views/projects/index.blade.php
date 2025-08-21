@extends('layouts.app')

@section('content')
<div class="min-h-screen flex flex-col">
    <header class="bg-blue-600 text-white shadow-md sticky top-0 z-10">
        <div class="container mx-auto px-4 py-4 flex items-center justify-between">
            <div class="flex items-center space-x-2">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5" />
                </svg>
                <h1 class="text-xl font-bold hidden sm:block">Task Manager</h1>
            </div>

            <!-- nav bar -->
            <nav class="flex space-x-6">
                <a href="{{ url('/') }}" class="hover:text-gray-200 transition">Home</a>
                <a href="{{ route('projects.index') }}" class="font-semibold hover:text-gray-200 transition">Projects</a>
                <a href="{{ route('tasks.index') }}" class="hover:text-gray-200 transition">Tasks</a>
            </nav>

            <div class="flex items-center space-x-2">
                <span class="text-sm sm:inline hidden">Chijindu Nwokeohuru</span>
                <div class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center text-sm">
                    <svg class="w-5 h-5 text-gray-600 sm:inline hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 15c2.5 0 4.847.655 6.879 1.804M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span class="sm:hidden">C.N</span>
                </div>
            </div>
        </div>
    </header>

    <!-- main content -->
    <main class="container mx-auto px-4 py-6 flex-1">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <div class="mb-6">
                <form method="GET" action="{{ route('projects.index') }}" class="w-full md:w-1/3">
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Search projects..." class="w-full border border-gray-200 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 transition" />
                </form>
            </div>

            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8 gap-4">
                <h1 class="text-3xl font-extrabold text-gray-800 animate-fade-in">Projects</h1>
                <div class="flex flex-col sm:flex-row gap-4">
                    <button type="button" id="open-create-project-modal"
                       class="bg-gradient-to-r from-blue-500 to-purple-600 text-white px-6 py-3 rounded-full shadow-lg hover:shadow-xl transition-transform duration-300 transform hover:scale-105">
                        + Create Project
                    </button>
                </div>
            </div>

            <!-- success alert -->
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg animate-fade-in">
                    {{ session('success') }}
                </div>
            @endif

            <!-- grid -->
            <div class="grid md:grid-cols-3 gap-6">
                @forelse($projects as $project)
                    <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                        <div class="p-4 flex flex-col items-center bg-gray-50">
                            <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center mb-2">
                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h2 class="text-lg font-semibold text-gray-800">{{ $project->name }}</h2>
                        </div>
                        <div class="p-4">
                            <div class="flex justify-between text-sm text-gray-600 mb-2">
                                <span>🕒 {{ $project->created_at->format('jS F Y') }}</span>
                            </div>
                            <div class="flex justify-between text-sm text-gray-600 mb-4">
                                <span>👥 {{ $project->tasks->count() }} Members</span>
                            </div>
                            <div class="relative pt-1">
                                <div class="overflow-hidden h-2 mb-1 text-xs flex rounded bg-pink-200">
                                    <div style="width:50%" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-pink-500"></div>
                                </div>
                            </div>
                        </div>
                        <div class="p-4 flex justify-end gap-2 border-t">
                            <button type="button" class="text-blue-500 hover:text-blue-700 transition open-project-modal" data-action="view" data-id="{{ $project->id }}">View</button>
                            <button type="button" class="text-purple-500 hover:text-purple-700 transition open-project-modal" data-action="edit" data-id="{{ $project->id }}">Edit</button>
                            <button type="button" class="text-red-500 hover:text-red-700 transition open-delete-project-modal" data-id="{{ $project->id }}">Delete</button>
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 bg-white p-6 rounded-xl shadow-md text-gray-500 text-center">
                        No projects found.
                    </div>
                @endforelse
            </div>
            <div class="mt-6">
                {{ $projects->links() }}
            </div>

        <!-- modal -->
        <div id="project-modal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 hidden">
            <div class="bg-white rounded-xl shadow-2xl max-w-lg w-full p-8 relative animate-fade-in">
                <button id="close-project-modal" class="absolute top-2 right-2 text-gray-400 hover:text-gray-700 text-2xl">&times;</button>
                <div id="project-modal-content">
                    <!-- AJAX content -->
                </div>
            </div>
        </div>

        <!-- delete confirm modal -->
        <div id="delete-project-modal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 hidden">
            <div class="bg-white rounded-xl shadow-2xl max-w-sm w-full p-6 relative animate-fade-in">
                <button id="close-delete-project-modal" class="absolute top-2 right-2 text-gray-400 hover:text-gray-700 text-2xl">&times;</button>
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Confirm Delete</h3>
                <p class="text-gray-600 mb-6">Are you sure you want to delete this project?</p>
                <div class="flex justify-end gap-4">
                    <form id="delete-project-form" action="" method="POST" class="hidden">
                        @csrf @method('DELETE')
                    </form>
                    <button type="button" id="cancel-delete-project" class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400 transition">Cancel</button>
                    <button type="button" id="confirm-delete-project" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition">Yes, Delete</button>
                </div>
            </div>
        </div>
        </div>
    </main>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // create, edit, view modal
    function openProjectModal(contentUrl, method = 'GET', data = null) {
        const modal = document.getElementById('project-modal');
        const modalContent = document.getElementById('project-modal-content');
        modalContent.innerHTML = '<div class="text-center py-8"><span class="text-gray-400">Loading...</span></div>';
        modal.classList.remove('hidden');
        fetch(contentUrl, {
            method: method,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: data ? JSON.stringify(data) : null
        })
        .then(response => response.text())
        .then(html => {
            modalContent.innerHTML = html;
        });
    }

    document.getElementById('open-create-project-modal').addEventListener('click', function() {
        openProjectModal("{{ route('projects.create') }}");
    });

    document.querySelectorAll('.open-project-modal').forEach(function(btn) {
        btn.addEventListener('click', function() {
            const action = btn.getAttribute('data-action');
            const id = btn.getAttribute('data-id');
            let url = '';
            if (action === 'view') {
                url = `/projects/${id}`;
            } else if (action === 'edit') {
                url = `/projects/${id}/edit`;
            }
            openProjectModal(url);
        });
    });

    document.getElementById('close-project-modal').addEventListener('click', function() {
        document.getElementById('project-modal').classList.add('hidden');
    });

    // close modal on outside click
    document.getElementById('project-modal').addEventListener('click', function(e) {
        if (e.target === this) {
            this.classList.add('hidden');
        }
    });

    // confirm delete
    function openDeleteProjectModal(projectId) {
        const modal = document.getElementById('delete-project-modal');
        const form = document.getElementById('delete-project-form');
        form.action = `{{ route('projects.destroy', ':id') }}`.replace(':id', projectId);
        modal.classList.remove('hidden');
    }

    document.querySelectorAll('.open-delete-project-modal').forEach(function(btn) {
        btn.addEventListener('click', function() {
            const id = btn.getAttribute('data-id');
            openDeleteProjectModal(id);
        });
    });

    document.getElementById('close-delete-project-modal').addEventListener('click', function() {
        document.getElementById('delete-project-modal').classList.add('hidden');
    });

    document.getElementById('cancel-delete-project').addEventListener('click', function() {
        document.getElementById('delete-project-modal').classList.add('hidden');
    });

    document.getElementById('confirm-delete-project').addEventListener('click', function() {
        document.getElementById('delete-project-form').submit();
    });

    // close delete modal on outside click
    document.getElementById('delete-project-modal').addEventListener('click', function(e) {
        if (e.target === this) {
            this.classList.add('hidden');
        }
    });
</script>

<style>
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in {
        animation: fadeIn 0.5s ease-out forwards;
    }
</style>
@endsection
