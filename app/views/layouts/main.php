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

    <main class="flex">
        <!-- LEFT: CONTENT -->
        <div id="app" class="w-2/3 p-6 overflow-auto">
            <h1 class="text-3xl font-bold">Hello from Wetube</h1>
        </div>

        <!-- RIGHT: FIXED PLAYLIST -->
        <div id="listsongs" class="w-1/3 p-6 border-l border-[#303030] overflow-y-auto">
            <?php
            use Core\Database;
            $db = Database::getInstance();
            $stmt = $db->query("SELECT songs.*, users.username AS artist FROM songs LEFT JOIN users ON songs.user_id = users.id ORDER BY songs.created_at DESC");
            $songs = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $this->insert('songs/listsongs', ['songs' => $songs]);
            ?>
        </div>
    </main>

    <!-- MODALS -->
    <div id="loginModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-50 hidden">
        <div id="loginModalContent" class="bg-[#1e1e1e] rounded-lg shadow-lg p-6 w-full max-w-md text-white relative">
            <button onclick="closeLoginModal()" class="absolute top-2 right-3 text-xl hover:text-red-500">×</button>
            <div id="loginFormContent">
                <p>Loading...</p>
            </div>
        </div>
    </div>
    
    <div id="registerModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-50 hidden">
        <div id="registerModalContent" class="bg-[#1e1e1e] rounded-lg shadow-lg p-6 w-full max-w-md text-white relative">
            <button onclick="closeRegisterModal()" class="absolute top-2 right-3 text-xl hover:text-red-500">×</button>
            <div id="registerFormContent">
                <p>Loading...</p>
            </div>
        </div>
    </div>

    <div id="uploadModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-50 hidden">
        <div id="uploadModalContent" class="bg-[#1e1e1e] rounded-lg shadow-lg p-6 w-full max-w-xl text-white relative">
            <button onclick="closeUploadModal()" class="absolute top-2 right-3 text-xl hover:text-red-500">×</button>
            <div id="uploadFormContent">
                <p>Đang tải...</p>
            </div>
        </div>
    </div>

    <!-- AUDIO CONTROLLER BAR sẽ đặt bên dưới -->
    <?php $this->insert('layouts/controllerbar'); ?>

    <!-- SCRIPT -->
    <script>
        const BASE = "<?= BASE_URL ?>";
    </script>
    <script src="<?= $this->asset('/assets/js/script.js') ?>?v=<?= time() ?>"></script>
</body>
</html>
