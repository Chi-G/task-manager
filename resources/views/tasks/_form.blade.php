<form id="task-modal-form" method="POST" action="{{ isset($task) ? route('tasks.update', $task) : route('tasks.store') }}">
    @csrf
    @if(isset($task))
        @method('PUT')
    @endif
    <div class="mb-6">
        <label for="name" class="block text-gray-700 font-semibold mb-2">Task Name</label>
        <input type="text" name="name" id="name" value="{{ old('name', $task->name ?? '') }}"
               class="w-full border border-gray-200 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
               required>
        @error('name')
            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
        @enderror
    </div>
    <div class="mb-6">
        <label for="project_id" class="block text-gray-700 font-semibold mb-2">Project</label>
        <select name="project_id" id="project_id"
                class="w-full border border-gray-200 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
                required>
            @foreach($projects as $project)
                <option value="{{ $project->id }}" {{ old('project_id', $task->project_id ?? null) == $project->id ? 'selected' : '' }}>
                    {{ $project->name }}
                </option>
            @endforeach
        </select>
        @error('project_id')
            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
        @enderror
    </div>
    <div class="flex justify-end gap-4">
        <button type="button" id="cancel-task-modal" class="bg-gray-200 text-gray-700 px-6 py-3 rounded-full hover:bg-gray-300 transition-transform duration-300 transform hover:scale-105">Cancel</button>
        <button type="submit" class="bg-gradient-to-r from-blue-500 to-purple-600 text-white px-6 py-3 rounded-full shadow-lg hover:shadow-xl transition-transform duration-300 transform hover:scale-105">
            {{ isset($task) ? 'Update Task' : 'Save Task' }}
        </button>
    </div>
</form>
<script>
document.getElementById('cancel-task-modal').onclick = function() {
    document.getElementById('task-modal').classList.add('hidden');
};
document.getElementById('task-modal-form').onsubmit = function(e) {
    e.preventDefault();
    const form = e.target;
    const url = form.action;
    const method = form.querySelector('input[name="_method"]') ? form.querySelector('input[name="_method"]').value : 'POST';
    const formData = new FormData(form);
    fetch(url, {
        method: method === 'PUT' ? 'POST' : method,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else if (data.html) {
            document.getElementById('task-modal-content').innerHTML = data.html;
        }
    })
};
</script>
