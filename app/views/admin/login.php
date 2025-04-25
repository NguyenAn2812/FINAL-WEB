<form id="login-form" action="<?= BASE_URL ?>/admin/login" method="POST" class="bg-[#1e1e1e] p-6 rounded-lg shadow-lg w-full max-w-md mx-auto mt-10">
    <h2 class="text-2xl font-bold text-center mb-6">Admin Login</h2>

    <div class="mb-4">
        <label for="username" class="block text-sm font-medium text-gray-300 mb-2">Username</label>
        <input type="text" id="username" name="username" required
            class="w-full p-2 rounded bg-[#2a2a2a] border border-gray-600 focus:outline-none focus:border-blue-500 text-white">
    </div>

    <div class="mb-6">
        <label for="password" class="block text-sm font-medium text-gray-300 mb-2">Password</label>
        <input type="password" id="password" name="password" required
            class="w-full p-2 rounded bg-[#2a2a2a] border border-gray-600 focus:outline-none focus:border-blue-500 text-white">
    </div>

    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 rounded">
        Login
    </button>
</form>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('login-form');
    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        const formData = new FormData(form);
        const response = await fetch(form.action, {
            method: 'POST',
            body: formData
        });

        const result = await response.json();

        if (result.success) {
            window.location.href = "<?= BASE_URL ?>/admin/dashboard";
        } else {
            alert(result.message);
        }
    });
});
</script>
