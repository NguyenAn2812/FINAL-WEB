<div class="max-w-6xl mx-auto py-10 px-6 text-white">
    <!-- Header -->
    <div class="flex items-center justify-between mb-8">
        <div class="flex items-center space-x-6">
            <img src="<?= BASE_URL ?>/uploads/avatars/<?= htmlspecialchars($user['avatar'] ?? 'default.png') ?>"
                 alt="Avatar"
                 class="w-24 h-24 rounded-full object-cover border border-gray-500">

            <div>
                <h2 class="text-3xl font-bold"><?= htmlspecialchars($user['username']) ?></h2>
                <p class="text-gray-400"><?= htmlspecialchars($user['email']) ?></p>
            </div>
        </div>

        <button onclick="openEditProfileModal()"
                class="bg-blue-600 px-4 py-2 rounded hover:bg-blue-500">
            Edit Profile
        </button>
    </div>

    <div>
        <h3 class="text-xl font-semibold mb-4">Songs You've Uploaded</h3>

        <?php if (!empty($songs)): ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                <?php foreach ($songs as $song): ?>
                    <?php include __DIR__ . '/../songs/songcard.php'; ?>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="text-gray-400">You haven't uploaded any songs yet.</p>
        <?php endif; ?>
    </div>
</div>
<div id="editProfileModal" class="fixed inset-0 bg-black/50 flex items-center justify-center hidden z-50">
    <div class="bg-[#181818] p-6 rounded shadow-lg w-full max-w-lg text-white">
        <h3 class="text-xl font-bold mb-4">Edit</h3>
        <form id="editProfileForm" enctype="multipart/form-data">
            <input type="text" name="username" value="<?= htmlspecialchars($user['username']) ?>"
                class="w-full p-2 rounded bg-[#1f1f1f] mb-3">

            <input type="password" name="current_password" placeholder="Current Password"
                class="w-full p-2 rounded bg-[#1f1f1f] mb-3">

            <input type="password" name="new_password" placeholder="New Password"
                class="w-full p-2 rounded bg-[#1f1f1f] mb-3">

            <label class="block mb-3">
                Upload New Avatar:
                <input type="file" name="avatar" accept="image/*" class="block mt-1">
            </label>

            <button class="bg-green-600 px-4 py-2 rounded hover:bg-green-500">
                Lưu thay đổi
            </button>
            <button type="button" onclick="closeEditProfileModal()" class="ml-4 text-gray-400 hover:text-white">
                Hủy
            </button>

            <p id="editProfileError" class="text-red-500 mt-3 hidden"></p>
        </form>

    </div>
</div>