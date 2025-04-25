<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel - Wetube Music</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body class="bg-dark text-white">

<nav class="navbar navbar-expand-lg navbar-dark bg-black px-5">
    <a class="navbar-brand" href="<?= BASE_URL ?>/admin/dashboard">Admin Panel</a>

    <div class="collapse navbar-collapse">
        <ul class="navbar-nav ms-auto">
            <?php if (!empty($_SESSION['user'])): ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?= BASE_URL ?>/admin/logout">Logout (<?= htmlspecialchars($_SESSION['user']['username']) ?>)</a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</nav>

<main class="container-fluid py-4">
    <?= $content ?? '' ?>
</main>

</body>
</html>
