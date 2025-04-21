<h2 class="text-2xl font-semibold text-center mb-4">Register</h2>

<form method="POST" action="<?= BASE_URL ?>/register" class="space-y-4">

    <div>
        <label for="username" class="block text-sm mb-1">User name</label>
        <input type="text" name="username" id="username" required
            class="w-full p-2 rounded bg-[#2a2a2a] border border-gray-700 text-white">
    </div>

    <div>
        <label for="email" class="block text-sm mb-1">Email</label>
        <input type="email" name="email" id="email" required
            class="w-full p-2 rounded bg-[#2a2a2a] border border-gray-700 text-white">
    </div>

    <div>
        <label for="password" class="block text-sm mb-1">Password</label>
        <input type="password" name="password" id="password" required
            class="w-full p-2 rounded bg-[#2a2a2a] border border-gray-700 text-white">
    </div>

    <div>
        <label for="password_confirmation" class="block text-sm mb-1">Confirm password</label>
        <input type="password" name="password_confirmation" id="password_confirmation" required
            class="w-full p-2 rounded bg-[#2a2a2a] border border-gray-700 text-white">
    </div>

    <button type="submit"
        class="w-full bg-[#3ea6ff] px-4 py-2 rounded hover:bg-[#60b6ff] text-white transition">
        Register
    </button>
</form>

<p class="text-sm mt-4 text-center text-gray-400">
    Already have an account?
    <a href="#" onclick="openLoginModal(); closeRegisterModal()" class="text-[#3ea6ff] hover:underline">
        Login
    </a>
</p>
