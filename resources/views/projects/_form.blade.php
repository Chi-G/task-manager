<form id="project-modal-form" method="POST" action="{{ isset($project) ? route('projects.update', $project) : route('projects.store') }}">
    @csrf
    @if(isset($project))
        @method('PUT')
    @endif
    <div class="mb-6">
        <label for="name" class="block text-gray-700 font-semibold mb-2">Project Name</label>
        <input type="text" name="name" id="name" value="{{ old('name', $project->name ?? '') }}"
               class="w-full border border-gray-200 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
               required>
        @error('name')
            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
        @enderror
    </div>
    <div class="flex justify-end gap-4">
        <button type="button" id="cancel-project-modal" class="bg-gray-200 text-gray-700 px-6 py-3 rounded-full hover:bg-gray-300 transition-transform duration-300 transform hover:scale-105">Cancel</button>
        <button type="submit" class="bg-gradient-to-r from-blue-500 to-purple-600 text-white px-6 py-3 rounded-full shadow-lg hover:shadow-xl transition-transform duration-300 transform hover:scale-105">
            {{ isset($project) ? 'Update Project' : 'Save Project' }}
        </button>
    </div>
</form>
<script>
document.getElementById('cancel-project-modal').onclick = function() {
    document.getElementById('project-modal').classList.add('hidden');
};
document.getElementById('project-modal-form').onsubmit = function(e) {
    e.preventDefault();
    const form = e.target;
    const url = form.action;
    const method = form.querySelector('input[name="_method"]') ? form.querySelector('input[name="_method"]').value : 'POST';
    const formData = new FormData(form);
    // (Spinner overlay removed)
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
    // (Spinner overlay removed)
        if (data.success) {
            location.reload();
        } else if (data.html) {
            document.getElementById('project-modal-content').innerHTML = data.html;
        }
    })
    .catch(() => {
        // (Spinner overlay removed)
    });
};
</script>
