<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#121212] text-white">

    <!-- DASHBOARD NỘI DUNG CHÍNH -->
    <div class="p-8">
        <h1 class="text-3xl font-bold mb-6">Welcome to Admin Dashboard</h1>

        <!-- Bảng người dùng -->
        <h2 class="text-xl font-semibold mt-6 mb-2">Users</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm bg-[#1f1f1f]">
                <thead><tr class="bg-[#2c2c2c] text-left text-gray-400">
                    <th class="p-2">ID</th><th class="p-2">Username</th><th class="p-2">Email</th><th class="p-2">Role</th>
                </tr></thead>
                <tbody>
                    <?php foreach ($users ?? [] as $u): ?>
                    <tr class="border-b border-gray-700 hover:bg-[#2a2a2a]">
                        <td class="p-2"><?= $u['id'] ?></td>
                        <td class="p-2"><?= $u['username'] ?></td>
                        <td class="p-2"><?= $u['email'] ?></td>
                        <td class="p-2"><?= $u['role'] ?></td>
                    </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>

        <!-- Bạn có thể thêm bảng songs / playlists ở đây -->
    </div>

    <!-- LOGIN POPUP -->
    <?php if ($showLogin ?? false): ?>
    <div id="login-popup" class="fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-50">
        <div class="bg-[#1f1f1f] p-8 rounded-lg shadow-lg w-full max-w-md">
            <h2 class="text-2xl font-bold text-center mb-4">Admin Login</h2>
            <form id="loginForm" action="<?= BASE_URL ?>/admin/login" method="POST" class="space-y-4">
                <p id="loginError" class="text-red-400 text-center hidden"></p>

                <input type="text" name="username" placeholder="Username"
                       class="w-full p-2 rounded bg-[#2a2a2a] border border-gray-700 text-white" required>

                <input type="password" name="password" placeholder="Password"
                       class="w-full p-2 rounded bg-[#2a2a2a] border border-gray-700 text-white" required>

                <button type="submit"
                        class="w-full bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                    Login
                </button>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('loginForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            const form = e.target;
            const data = new FormData(form);
            const res = await fetch(form.action, { method: 'POST', body: data });
            const result = await res.json();

            if (result.success) {
                document.getElementById('login-popup').classList.add('hidden');
                location.reload(); // Hoặc bỏ dòng này nếu bạn đã load sẵn data
            } else {
                const err = document.getElementById('loginError');
                err.textContent = result.message || "Login failed!";
                err.classList.remove('hidden');
            }
        });
    </script>
    <?php endif; ?>

</body>
</html>
