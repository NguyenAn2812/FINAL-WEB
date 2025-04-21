<header class="flex items-center justify-between px-4 py-2 border-b border-[#303030] shadow-sm sticky top-0 bg-[#181818] text-white z-50">
    <a href="#" onclick="loadComponent('home')" class="flex items-center space-x-2 text-white text-xl font-bold">
        <i class="mdi mdi-youtube text-red-600 text-5xl"></i>
        <span>Wetube music</span>
    </a>

    <div class="flex items-center space-x-4 relative" id="navbar-user">
        <?php if (isset($_SESSION['user'])): ?>
            <button onclick="openUploadModal()" class="px-3 py-2 rounded-full font-medium border border-white text-white hover:bg-white hover:text-black transition">
                Upload
            </button>

            <button id="avatar-toggle" onclick="toggleDropdown()" class="flex items-center space-x-1 text-sm font-medium text-white hover:text-gray-300">
                <img src="<?= BASE_URL . '/' . ($_SESSION['user']['avatar'] ?? 'uploads/avatars/default.png') ?>" class="w-8 h-8 rounded-full object-cover" alt="avatar">
                    <span><?= htmlspecialchars($_SESSION['user']['username']) ?></span>
            </button>

            <div id="dropdownMenu" class="hidden absolute right-0 top-12 bg-[#181818] text-white shadow-md rounded border border-[#303030] w-40 z-50">
                <button onclick="loadComponent('my-videos')" class="w-full text-left px-4 py-2 hover:bg-[#2a2a2a]">
                    <i class="mdi mdi-filmstrip mr-2"></i> My Videos
                </button>
                <button onclick="loadComponent('account')" class="w-full text-left px-4 py-2 hover:bg-[#2a2a2a]">
                    <i class="mdi mdi-account-edit mr-2"></i> Edit Account
                </button>
                <form action="<?= BASE_URL ?>/logout" method="GET">
                    <button class="w-full text-left px-4 py-2 hover:bg-[#2a2a2a]">
                        <i class="mdi mdi-logout mr-2"></i> Logout
                    </button>
                </form>
            </div>
        <?php else: ?>
            <a href="#" onclick="openLoginModal()" class="text-xl border border-[#3ea6ff] text-[#3ea6ff] px-4 py-1 rounded-full hover:bg-[#3ea6ff]/10 transition">
                Login
            </a>
        <?php endif; ?>
    </div>
    
</header>

<!-- <script>
function toggleDropdown() {
    document.getElementById('dropdownMenu').classList.toggle('hidden');
}

document.addEventListener('click', function (e) {
    const menu = document.getElementById('dropdownMenu');
    const btn = document.getElementById('avatar-toggle');
    if (!menu || !btn) return;
    if (!btn.contains(e.target) && !menu.contains(e.target)) {
        menu.classList.add('hidden');
    }
});
</script> -->
