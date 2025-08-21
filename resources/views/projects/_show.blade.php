<h2 class="text-xl font-semibold text-gray-800 mb-4">Project Details</h2>
<div class="space-y-3">
    <p><span class="font-semibold text-gray-700">Name:</span> {{ $project->name }}</p>
    <p><span class="font-semibold text-gray-700">Created:</span> {{ $project->created_at->format('M d, Y H:i') }}</p>
    <p><span class="font-semibold text-gray-700">Updated:</span> {{ $project->updated_at->format('M d, Y H:i') }}</p>
</div>
