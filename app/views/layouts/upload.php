<h2 class="text-xl font-bold mb-4 text-center">Upload songs</h2>

<form id="uploadForm" action="<?= BASE_URL ?>/song/upload" method="post" enctype="multipart/form-data" class="space-y-4">
    <input type="text" name="title" placeholder="Title" required
        class="w-full p-2 rounded bg-[#0f0f0f] border border-[#303030] text-white" />

    <textarea name="description" placeholder="description" rows="3"
        class="w-full p-2 rounded bg-[#0f0f0f] border border-[#303030] text-white"></textarea>

    <input type="file" name="file" accept="audio/*" required
        class="w-full text-sm bg-[#0f0f0f] border border-[#303030] rounded p-2 text-white" />

    <input type="file" name="thumbnail" accept="image/*" required
        class="w-full text-sm bg-[#0f0f0f] border border-[#303030] rounded p-2 text-white" />

    <button type="submit"
        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded transition">
        Tải lên
    </button>
</form>
