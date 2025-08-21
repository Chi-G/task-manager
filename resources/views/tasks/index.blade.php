@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
<script>
    // delete confirmation for tasks with overlay for outside click
    var taskDeleteForm = null;
    var deleteOverlay = null;
    $(document).on('click', '.delete-task-btn', function(e) {
        e.preventDefault();
        taskDeleteForm = $(this).closest('form')[0];

        // overlay for outside click detection
        deleteOverlay = $('<div>').addClass('fixed inset-0 z-40 bg-black bg-opacity-50').appendTo('body');

        toastr.clear();
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-center",
            "timeOut": 0,
            "extendedTimeOut": 0,
            "tapToDismiss": false,
            "onclick": function(e) {
                if ($(e.target).hasClass('confirm-delete-task')) {
                    if (taskDeleteForm) {
                        taskDeleteForm.submit();
                        taskDeleteForm = null;
                    }
                    toastr.clear();
                    deleteOverlay.remove();
                } else if ($(e.target).hasClass('cancel-delete-task')) {
                    toastr.clear();
                    deleteOverlay.remove();
                }
            },
            "onHidden": function() {
                deleteOverlay.remove();
            }
        };
        toastr.warning(
            '<div class="mb-2">Are you sure you want to delete this task?</div>' +
            '<button type="button" class="confirm-delete-task bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded mr-2">Yes, Delete</button>' +
            '<button type="button" class="cancel-delete-task bg-gray-300 hover:bg-gray-400 text-gray-800 px-3 py-1 rounded">Cancel</button>',
            'Confirm Delete',
            {
                "closeButton": false,
                "allowHtml": true
            }
        );

        // outside click on overlay
        deleteOverlay.on('click', function() {
            toastr.clear();
            $(this).remove();
        });
    });

    //  create, edit, view modal
    function openTaskModal(contentUrl, method = 'GET', data = null) {
        const modal = document.getElementById('task-modal');
        const modalContent = document.getElementById('task-modal-content');
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

    document.addEventListener('DOMContentLoaded', function() {
        var createBtn = document.getElementById('open-create-task-modal');
        if (createBtn) {
            createBtn.addEventListener('click', function() {
                openTaskModal("{{ route('tasks.create') }}");
            });
        }

        document.querySelectorAll('.open-task-modal').forEach(function(btn) {
            btn.addEventListener('click', function() {
                const action = btn.getAttribute('data-action');
                const id = btn.getAttribute('data-id');
                let url = '';
                if (action === 'view') {
                    url = `/tasks/${id}`;
                } else if (action === 'edit') {
                    url = `/tasks/${id}/edit`;
                }
                openTaskModal(url);
            });
        });

        var closeBtn = document.getElementById('close-task-modal');
        if (closeBtn) {
            closeBtn.addEventListener('click', function() {
                document.getElementById('task-modal').classList.add('hidden');
            });
        }

        var modal = document.getElementById('task-modal');
        if (modal) {
            modal.addEventListener('click', function(e) {
                if (e.target === this) {
                    this.classList.add('hidden');
                }
            });
        }
    });

    // initialize drag-and-drop with sortableJS
    const taskList = document.getElementById('task-list');
    if (taskList) {
        new Sortable(taskList, {
            animation: 150,
            handle: '.cursor-move',
            onEnd: async function (evt) {
                const taskIds = Array.from(taskList.querySelectorAll('li[data-id]')).map(li => li.dataset.id);
                await fetch('{{ route('tasks.reorder') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ task_ids: taskIds })
                });
                location.reload();
            }
        });
    }
</script>
@endpush
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
            <form method="GET" action="{{ route('tasks.index') }}" class="mb-6 flex flex-col md:flex-row md:items-center gap-2">
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Search tasks..."
                    class="w-full md:w-1/3 border border-gray-200 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
                >
                @if(request('search'))
                    <a href="{{ route('tasks.index', array_filter(['project_id' => request('project_id')])) }}" class="text-sm text-gray-500 hover:underline ml-2">Clear</a>
                @endif
            </form>

            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8 gap-4">
                <h1 class="text-3xl font-extrabold text-gray-800 animate-fade-in">Task Management</h1>
                <div class="flex flex-col sm:flex-row gap-4">
                    <button type="button" id="open-create-task-modal"
                       class="bg-gradient-to-r from-blue-500 to-purple-600 text-white px-6 py-3 rounded-full shadow-lg hover:shadow-xl transition-transform duration-300 transform hover:scale-105">
                        + Create Task
                    </button>
                </div>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg animate-fade-in">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-lg animate-fade-in">
                    {{ session('error') }}
                </div>
            @endif

            <!-- project dropdown -->
            <form method="GET" class="mb-8 max-w-md">
                <label for="project_id" class="block text-gray-700 font-semibold mb-2">Filter by Project</label>
                <select name="project_id" id="project_id" onchange="this.form.submit()"
                        class="w-full border border-gray-200 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 transition bg-white">
                    <option value="">All Projects</option>
                    @foreach($projects as $project)
                        <option value="{{ $project->id }}" {{ $selectedProjectId == $project->id ? 'selected' : '' }}>
                            {{ $project->name }}
                        </option>
                    @endforeach
                </select>
            </form>

            <!-- task list with drag-and-drop -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <ul id="task-list" class="divide-y divide-gray-100">
                    @forelse($tasks as $task)
                        <li class="p-4 group hover:bg-gray-50 transition-all duration-200" data-id="{{ $task->id }}">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-4">
                                    <span class="cursor-move text-gray-400 hover:text-gray-600 transition">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                                        </svg>
                                    </span>
                                    <div>
                                        <button type="button" class="text-lg font-semibold text-gray-800 hover:text-blue-600 transition open-task-modal" data-action="view" data-id="{{ $task->id }}">
                                            {{ $task->name }}
                                        </button>
                                        <p class="text-sm text-gray-500">Project: {{ $task->project->name }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-4 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <button type="button" class="text-purple-500 hover:text-purple-700 transition open-task-modal" data-action="edit" data-id="{{ $task->id }}">Edit</button>
                                    <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="delete-task-form inline">
                                        @csrf @method('DELETE')
                                        <button type="button" class="text-red-500 hover:text-red-700 transition delete-task-btn">Delete</button>
                                    </form>
                                </div>
                            </div>
                            <div class="mt-2 text-sm text-gray-600">
                                <span>Priority: {{ $task->priority }}</span>
                                <span class="ml-4">🕒 Deadline</span>
                            </div>
                            <div class="mt-2 relative pt-1">
                                <div class="overflow-hidden h-2 mb-1 text-xs flex rounded bg-pink-200">
                                    <div style="width:50%" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-pink-500"></div>
                                </div>
                                <p class="text-xs text-pink-500 text-right">Days Left</p>
                            </div>
                        </li>
                    @empty
                        <li class="p-4 text-gray-500 text-center">No tasks found.</li>
                    @endforelse
                </ul>
            </div>
            <div class="mt-6">
                {{ $tasks->links() }}
            </div>
            <!-- task modal -->
            <div id="task-modal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 hidden">
                <div class="bg-white rounded-xl shadow-2xl max-w-lg w-full p-8 relative animate-fade-in">
                    <button id="close-task-modal" class="absolute top-2 right-2 text-gray-400 hover:text-gray-700 text-2xl">&times;</button>
                    <div id="task-modal-content">
                        <!-- AJAX content -->
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

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
