<h2 class="text-2xl font-bold mb-4">Upload a Song</h2>
<form method="POST" action="/upload" enctype="multipart/form-data" class="space-y-4">
    <input type="text" name="title" placeholder="Song title" class="form-control w-full p-2 rounded bg-[#2a2a2a] border border-gray-700 text-white">
    <input type="file" name="audio" class="text-white">
    <button type="submit" class="bg-blue-600 px-4 py-2 rounded hover:bg-blue-500">Upload</button>
</form>
