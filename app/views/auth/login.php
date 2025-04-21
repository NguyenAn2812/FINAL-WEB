<h2 class="text-2xl font-semibold text-center mb-4">Login</h2>

<form method="POST" action="<?= BASE_URL ?>/login" class="space-y-4">
    <div>
        <label for="username" class="block text-sm mb-1">User name</label>
        <input type="text" name="username" id="username" required
            class="w-full p-2 rounded bg-[#2a2a2a] border border-gray-700 text-white">
    </div>

    <div>
        <label for="password" class="block text-sm mb-1">Password</label>
        <input type="password" name="password" id="password" required
            class="w-full p-2 rounded bg-[#2a2a2a] border border-gray-700 text-white">
    </div>

    <button type="submit"
        class="w-full bg-[#3ea6ff] px-4 py-2 rounded hover:bg-[#60b6ff] text-white transition">
        Login
    </button>
</form>

<p class="text-sm mt-4 text-center text-gray-400">
    Don't have an account?
    <a href="#" onclick="openRegisterModal(); closeLoginModal()" class="text-[#3ea6ff] hover:underline">
        Register now
    </a>
</p>
