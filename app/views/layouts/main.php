
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Wetube</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font/css/materialdesignicons.min.css" rel="stylesheet">
</head>
<body class="bg-[#121212] text-white">

    <?php $this->insert('layouts/navbar'); ?>

    <main class="p-4">
        <h1 class="text-3xl font-bold">Hello from Wetube</h1>
    </main>

    <div id="loginModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-50 hidden">
        <div id="loginModalContent" class="bg-[#1e1e1e] rounded-lg shadow-lg p-6 w-full max-w-md text-white relative">
            <button onclick="closeLoginModal()" class="absolute top-2 right-3 text-xl hover:text-red-500">×</button>
            <div id="loginFormContent">
                <p>Loading...</p>
            </div>
        </div>
    </div>
    <!-- Register Modal -->
    <div id="registerModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-50 hidden">
        <div id="registerModalContent" class="bg-[#1e1e1e] rounded-lg shadow-lg p-6 w-full max-w-md text-white relative">
            <button onclick="closeRegisterModal()" class="absolute top-2 right-3 text-xl hover:text-red-500">×</button>
            <div id="registerFormContent">
                <p>Loading...</p>
            </div>
        </div>
    </div>

    <script>
        const BASE = "<?= BASE_URL ?>";
    </script>
    <script src="<?= $this->asset('/assets/js/script.js') ?>"></script>
</body>
</html>
