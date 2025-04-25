<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link href="<?= BASE_URL ?>/assets/css/style.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-white">

<div class="container py-5">
    <h1 class="mb-4">Admin Dashboard</h1>

    <h2>Users</h2>
    <table class="table table-dark table-striped">
        <thead>
            <tr>
                <th>ID</th><th>Username</th><th>Email</th><th>Role</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
            <tr>
                <td><?= htmlspecialchars($user['id']) ?></td>
                <td><?= htmlspecialchars($user['username']) ?></td>
                <td><?= htmlspecialchars($user['email']) ?></td>
                <td><?= htmlspecialchars($user['role'] ?? 'user') ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h2 class="mt-5">Songs</h2>
    <table class="table table-dark table-striped">
        <thead>
            <tr>
                <th>ID</th><th>Title</th><th>Artist</th><th>Filename</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($songs as $song): ?>
            <tr>
                <td><?= htmlspecialchars($song['id']) ?></td>
                <td><?= htmlspecialchars($song['title']) ?></td>
                <td><?= htmlspecialchars($song['artist']) ?></td>
                <td><?= htmlspecialchars($song['file']) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h2 class="mt-5">Playlists</h2>
    <table class="table table-dark table-striped">
        <thead>
            <tr>
                <th>ID</th><th>Name</th><th>User ID</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($playlists as $playlist): ?>
            <tr>
                <td><?= htmlspecialchars($playlist['id']) ?></td>
                <td><?= htmlspecialchars($playlist['name']) ?></td>
                <td><?= htmlspecialchars($playlist['user_id']) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</div>

</body>
</html>
