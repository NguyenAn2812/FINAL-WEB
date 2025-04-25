<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Wetube music</title>
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font/css/materialdesignicons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="<?= BASE_URL ?>/images/logo.svg"/>
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body class="bg-[#121212] text-white">

    <div class="container-fluid">
    </div>
    <div id="navbar">
        <?php $this->insert('layouts/navbar'); ?>
    </div>
    <main class="p-4">
        <div id = "app">
        </div>
        <?php $this->insert('layouts/controllerbar'); ?>
    </main>

  <!-- Login Modal -->
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


    <!-- Upload Modal -->
    <div id="uploadModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-50 hidden">
        <div id="uploadModalContent" class="bg-[#1e1e1e] rounded-lg shadow-lg p-6 w-full max-w-xl text-white relative">
            <button onclick="closeUploadModal()" class="absolute top-2 right-3 text-xl hover:text-red-500">×</button>
            <div id="uploadFormContent">
                <p>Loading...</p>
            </div>
        </div>
    </div>

    <script>
        const BASE = "<?= BASE_URL ?>";
    </script>
    <script src="<?= BASE_URL ?>/assets/js/script.js?v=<?= time() ?>"></script>
</body>

</html>