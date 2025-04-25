<?php
$action = BASE_URL . '/admin/login';
?>

<!-- Popup Login Admin -->
<div id="admin-login-popup" class="fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-50">
    <div class="bg-[#181818] text-white p-8 rounded-2xl shadow-xl w-96 relative">
        
        <h2 class="text-2xl font-bold text-center mb-6">Admin Login</h2>

        <form id="admin-login-form" method="POST" action="<?= $action ?>" class="flex flex-col space-y-4">
            <input type="text" name="username" placeholder="Username" required 
                   class="px-4 py-2 rounded bg-[#282828] border border-gray-700 focus:outline-none focus:ring-2 focus:ring-red-500">

            <input type="password" name="password" placeholder="Password" required 
                   class="px-4 py-2 rounded bg-[#282828] border border-gray-700 focus:outline-none focus:ring-2 focus:ring-red-500">

            <button type="submit" 
                    class="bg-red-500 hover:bg-red-600 transition-all text-white font-bold py-2 rounded mt-2">
                Login
            </button>

            <p id="admin-login-error" class="text-red-400 text-sm text-center hidden mt-2"></p>
        </form>
    </div>
</div>

<!-- Script xử lý login bằng fetch AJAX -->
<script>
document.getElementById('admin-login-form').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const form = e.target;
    const formData = new FormData(form);
    
    const response = await fetch(form.action, {
        method: 'POST',
        body: formData
    });
    
    const result = await response.json();
    
    if (result.success) {
        document.getElementById('admin-login-popup').classList.add('hidden');

    } else {
        const errorElement = document.getElementById('admin-login-error');
        errorElement.textContent = result.message || 'Login failed';
        errorElement.classList.remove('hidden');
    }
});
</script>
