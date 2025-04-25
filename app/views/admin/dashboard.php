<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-[#121212] text-white min-h-screen p-6">

    <h1 class="text-3xl font-bold mb-6 text-center">Admin Dashboard</h1>

    <!-- Điều hướng -->
    <div class="flex justify-center space-x-4 mb-8">
        <button onclick="openPopup('users')" class="bg-blue-500 hover:bg-blue-600 px-4 py-2 rounded">Users</button>
        <button onclick="openPopup('songs')" class="bg-green-500 hover:bg-green-600 px-4 py-2 rounded">Songs</button>
        <button onclick="openPopup('playlists')" class="bg-purple-500 hover:bg-purple-600 px-4 py-2 rounded">Playlists</button>
    </div>

    <!-- Biểu đồ thống kê -->
    <div class="w-full max-w-2xl mx-auto">
        <canvas id="chart-summary"></canvas>
    </div>

    <script>
        const chart = new Chart(document.getElementById('chart-summary'), {
            type: 'bar',
            data: {
                labels: ['Total Songs', 'Top Artist Song Count', 'Total Users'],
                datasets: [{
                    label: 'Statistics',
                    data: [<?= $totalSongs ?>, <?= $topArtistSongCount ?>, <?= $totalUsers ?>],
                    backgroundColor: ['#3b82f6', '#f59e0b', '#10b981']
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } }
            }
        });
    </script>

    <!-- Popups (Users / Songs / Playlists) -->
    <?php foreach (['users', 'songs', 'playlists'] as $type): ?>
    <div id="popup-<?= $type ?>" class="fixed inset-0 bg-black bg-opacity-60 z-50 hidden items-center justify-center">
        <div class="bg-[#1f1f1f] p-6 rounded-lg w-[90%] max-w-3xl max-h-[80vh] overflow-y-auto">
            <h2 class="text-xl font-bold mb-4 capitalize"><?= $type ?> list</h2>
            <table class="w-full text-sm table-auto border-collapse">
                <thead>
                    <tr id="<?= $type ?>-header" class="border-b border-gray-700 text-gray-400"></tr>
                </thead>
                <tbody id="<?= $type ?>-table" class="divide-y divide-gray-800"></tbody>
            </table>
            <button onclick="closePopup('<?= $type ?>')" class="mt-4 px-4 py-2 bg-gray-600 hover:bg-gray-700 rounded text-white">Close</button>
        </div>
    </div>
    <?php endforeach; ?>

    <script>
        const BASE = '<?= BASE_URL ?>/admin';

        function openPopup(type) {
            document.getElementById(`popup-${type}`).classList.remove('hidden');

            fetch(`${BASE}/data/${type}`)
                .then(res => res.json())
                .then(data => renderTable(type, data));
        }

        function closePopup(type) {
            document.getElementById(`popup-${type}`).classList.add('hidden');
        }

        function renderTable(type, data) {
            const table = document.getElementById(`${type}-table`);
            const header = document.getElementById(`${type}-header`);
            table.innerHTML = '';
            header.innerHTML = '';

            if (data.length === 0) {
                table.innerHTML = '<tr><td colspan="5" class="text-center text-gray-400">No data available.</td></tr>';
                return;
            }

            // Render header
            const keys = Object.keys(data[0]);
            header.innerHTML = keys.map(k => `<th class="px-2 py-1 text-left">${k}</th>`).join('') +
                (type === 'users' ? '<th class="px-2 py-1">Actions</th>' : '');

            // Render rows
            data.forEach(item => {
                let row = '<tr>';
                keys.forEach(k => {
                    if(k !== 'password') {
                        row += `<td class="px-2 py-1">${item[k]}</td>`; // Ẩn password
                    }
                });

                if (type === 'users') {
                    row += `<td class="px-2 py-1">
                        <button onclick="setMusician(${item.id})" class="text-blue-400 hover:underline">Set Musician</button>
                        <button onclick="deleteUser(${item.id})" class="text-red-400 hover:underline ml-2">Delete</button>
                    </td>`;
                }

                if (type === 'songs') {
                    row += `<td class="px-2 py-1">
                        <button onclick="deleteSong(${item.id})" class="text-red-400 hover:underline">Delete</button>
                    </td>`;
                }

                if (type === 'playlists') {
                    row += `<td class="px-2 py-1">
                        <button onclick="deletePlaylist(${item.id})" class="text-red-400 hover:underline">Delete</button>
                    </td>`;
                }
                
                row += '</tr>';
                table.innerHTML += row;
            });
        }

        function deleteUser(id) {
            if (confirm('Are you sure you want to delete this user?')) {
                fetch(`${BASE}/delete-user/${id}`, { method: 'POST' })
                    .then(() => openPopup('users'));
            }
        }

        function setMusician(id) {
            fetch(`${BASE}/set-musician/${id}`, { method: 'POST' })
                .then(() => openPopup('users'));
        }

        function deleteSong(id) {
            if (confirm('Are you sure you want to delete this song?')) {
                fetch(`${BASE}/delete-song/${id}`, { method: 'POST' })
                    .then(() => openPopup('songs'));
            }
        }

        function deletePlaylist(id) {
            if (confirm('Are you sure you want to delete this playlist?')) {
                fetch(`${BASE}/delete-playlist/${id}`, { method: 'POST' })
                    .then(() => openPopup('playlists'));
            }
        }
    </script>

</body>
</html>
