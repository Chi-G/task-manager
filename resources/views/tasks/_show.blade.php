<h2 class="text-xl font-semibold text-gray-800 mb-4">Task Details</h2>
<div class="space-y-3">
    <p><span class="font-semibold text-gray-700">Name:</span> {{ $task->name }}</p>
    <p><span class="font-semibold text-gray-700">Priority:</span> {{ $task->priority }}</p>
    <p><span class="font-semibold text-gray-700">Project:</span> {{ $task->project->name }}</p>
    <p><span class="font-semibold text-gray-700">Created:</span> {{ $task->created_at->format('M d, Y H:i') }}</p>
    <p><span class="font-semibold text-gray-700">Updated:</span> {{ $task->updated_at->format('M d, Y H:i') }}</p>
</div>
