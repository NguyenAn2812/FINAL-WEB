<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Custom animations */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        @keyframes slideIn {
            from { transform: translateY(-20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        
        .animate-fadeIn {
            animation: fadeIn 0.3s ease-out forwards;
        }
        
        .animate-slideIn {
            animation: slideIn 0.4s ease-out forwards;
        }
        
        /* Scrollbar styling */
        .custom-scrollbar::-webkit-scrollbar {
            width: 8px;
        }
        
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #2a2a2a;
            border-radius: 10px;
        }
        
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #4b5563;
            border-radius: 10px;
        }
        
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #6b7280;
        }
        
        /* Table styling */
        .data-table th {
            position: sticky;
            top: 0;
            background-color: #1a1a1a;
            z-index: 10;
        }
    </style>
</head>
<body class="bg-[#121212] text-white min-h-screen p-6 font-sans">
    <div class="max-w-7xl mx-auto">
        <h1 class="text-3xl font-bold mb-8 text-center bg-gradient-to-r from-blue-500 via-purple-500 to-pink-500 bg-clip-text text-transparent">Admin Dashboard</h1>

        <!-- Navigation Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
            <div onclick="openPopup('users')" class="bg-gradient-to-br from-blue-600 to-blue-800 rounded-xl p-6 shadow-lg cursor-pointer hover:shadow-blue-900/30 hover:shadow-xl transition-all duration-300">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-bold">Users</h3>
                    <i class="fas fa-users text-2xl opacity-80"></i>
                </div>
                <p class="mt-2 text-blue-200"><?= $totalUsers ?> registered users</p>
            </div>
            
            <div onclick="openPopup('songs')" class="bg-gradient-to-br from-green-600 to-green-800 rounded-xl p-6 shadow-lg cursor-pointer hover:shadow-green-900/30 hover:shadow-xl transition-all duration-300">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-bold">Songs</h3>
                    <i class="fas fa-music text-2xl opacity-80"></i>
                </div>
                <p class="mt-2 text-green-200"><?= $totalSongs ?> songs available</p>
            </div>
            
            <div onclick="openPopup('playlists')" class="bg-gradient-to-br from-purple-600 to-purple-800 rounded-xl p-6 shadow-lg cursor-pointer hover:shadow-purple-900/30 hover:shadow-xl transition-all duration-300">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-bold">Playlists</h3>
                    <i class="fas fa-list text-2xl opacity-80"></i>
                </div>
                <p class="mt-2 text-purple-200">Manage user playlists</p>
            </div>
        </div>

        <!-- Chart -->
        <div class="w-full max-w-3xl mx-auto bg-[#1a1a1a] p-6 rounded-xl shadow-lg mb-12">
            <h2 class="text-xl font-bold mb-4">Statistics Overview</h2>
            <canvas id="chart-summary" height="250"></canvas>
        </div>

        <script>
            const chart = new Chart(document.getElementById('chart-summary'), {
                type: 'bar',
                data: {
                    labels: ['Total Songs', 'Top Artist Song Count', 'Total Users'],
                    datasets: [{
                        label: 'Statistics',
                        data: [<?= $totalSongs ?>, <?= $topArtistSongCount ?>, <?= $totalUsers ?>],
                        backgroundColor: [
                            'rgba(59, 130, 246, 0.8)',
                            'rgba(245, 158, 11, 0.8)',
                            'rgba(16, 185, 129, 0.8)'
                        ],
                        borderColor: [
                            'rgb(59, 130, 246)',
                            'rgb(245, 158, 11)',
                            'rgb(16, 185, 129)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: { 
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: 'rgba(0, 0, 0, 0.8)',
                            titleColor: '#fff',
                            bodyColor: '#fff',
                            padding: 10,
                            cornerRadius: 6
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(255, 255, 255, 0.1)'
                            },
                            ticks: {
                                color: 'rgba(255, 255, 255, 0.7)'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                color: 'rgba(255, 255, 255, 0.7)'
                            }
                        }
                    }
                }
            });
        </script>
    </div>

    <!-- Improved Popups -->
    <?php foreach (['users', 'songs', 'playlists'] as $type): ?>
    <div id="popup-<?= $type ?>" class="fixed inset-0 bg-black bg-opacity-70 z-50 hidden items-center justify-center animate-fadeIn backdrop-blur-sm">
        <div class="bg-gradient-to-b from-[#1f1f1f] to-[#181818] p-0 rounded-xl w-[90%] max-w-4xl max-h-[85vh] shadow-2xl animate-slideIn overflow-hidden flex flex-col">
            <!-- Popup Header -->
            <div class="p-5 border-b border-gray-800 flex justify-between items-center bg-[#1a1a1a]">
                <div class="flex items-center">
                    <i class="fas fa-<?= $type === 'users' ? 'users' : ($type === 'songs' ? 'music' : 'list') ?> text-<?= $type === 'users' ? 'blue' : ($type === 'songs' ? 'green' : 'purple') ?>-500 mr-3"></i>
                    <h2 class="text-xl font-bold capitalize"><?= $type ?> Management</h2>
                </div>
                <div class="flex items-center gap-2">
                    <div id="<?= $type ?>-count" class="text-sm bg-gray-800 px-3 py-1 rounded-full"></div>
                    <button onclick="closePopup('<?= $type ?>')" class="text-gray-400 hover:text-white transition-colors">
                        <i class="fas fa-times text-lg"></i>
                    </button>
                </div>
            </div>
            
            <!-- Loading State -->
            <div id="loading-<?= $type ?>" class="flex-1 flex items-center justify-center p-10">
                <div class="flex flex-col items-center">
                    <div class="w-12 h-12 border-4 border-gray-600 border-t-<?= $type === 'users' ? 'blue' : ($type === 'songs' ? 'green' : 'purple') ?>-500 rounded-full animate-spin"></div>
                    <p class="mt-4 text-gray-400">Loading <?= $type ?>...</p>
                </div>
            </div>
            
            <!-- Table Container -->
            <div id="content-<?= $type ?>" class="flex-1 overflow-y-auto custom-scrollbar hidden p-5">
                <!-- Search and Filter -->
                <div class="mb-4 flex flex-col sm:flex-row gap-3">
                    <div class="relative flex-1">
                        <input type="text" id="search-<?= $type ?>" placeholder="Search <?= $type ?>..." 
                               class="w-full bg-[#2a2a2a] border border-gray-700 rounded-lg px-4 py-2 pl-10 focus:outline-none focus:ring-2 focus:ring-<?= $type === 'users' ? 'blue' : ($type === 'songs' ? 'green' : 'purple') ?>-500 focus:border-transparent">
                        <i class="fas fa-search absolute left-3 top-3 text-gray-500"></i>
                    </div>
                    <?php if ($type === 'users'): ?>
                    <select id="filter-<?= $type ?>" class="bg-[#2a2a2a] border border-gray-700 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="all">All Users</option>
                        <option value="admin">Admins</option>
                        <option value="musician">Musicians</option>
                        <option value="user">Regular Users</option>
                    </select>
                    <?php endif; ?>
                </div>
                
                <!-- Table -->
                <div class="overflow-x-auto rounded-lg border border-gray-800">
                    <table class="w-full text-sm table-auto border-collapse data-table">
                        <thead>
                            <tr id="<?= $type ?>-header" class="text-gray-400 bg-[#1a1a1a]"></tr>
                        </thead>
                        <tbody id="<?= $type ?>-table" class="divide-y divide-gray-800"></tbody>
                    </table>
                </div>
                
                <!-- No Results Message -->
                <div id="no-results-<?= $type ?>" class="hidden text-center py-10 text-gray-400">
                    <i class="fas fa-search text-3xl mb-3 opacity-50"></i>
                    <p>No <?= $type ?> found matching your search.</p>
                </div>
            </div>
            
            <!-- Footer -->
            <div class="p-4 border-t border-gray-800 flex justify-between items-center bg-[#1a1a1a]">
                <button onclick="closePopup('<?= $type ?>')" class="px-4 py-2 bg-gray-700 hover:bg-gray-600 rounded-lg text-white transition-colors flex items-center gap-2">
                    <i class="fas fa-arrow-left"></i> Back
                </button>
            </div>
        </div>
    </div>
    
    <!-- Confirmation Modal -->
    <div id="confirm-modal" class="fixed inset-0 bg-black bg-opacity-70 z-[60] hidden items-center justify-center animate-fadeIn backdrop-blur-sm">
        <div class="bg-[#1f1f1f] p-6 rounded-xl w-[90%] max-w-md shadow-2xl animate-slideIn">
            <h3 id="confirm-title" class="text-xl font-bold mb-4">Confirm Action</h3>
            <p id="confirm-message" class="text-gray-300 mb-6">Are you sure you want to perform this action?</p>
            <div class="flex justify-end gap-3">
                <button id="confirm-cancel" class="px-4 py-2 bg-gray-700 hover:bg-gray-600 rounded-lg text-white transition-colors">
                    Cancel
                </button>
                <button id="confirm-ok" class="px-4 py-2 bg-red-600 hover:bg-red-500 rounded-lg text-white transition-colors">
                    Confirm
                </button>
            </div>
        </div>
    </div>
    <?php endforeach; ?>

    <script>
        const BASE = '<?= BASE_URL ?>/admin';
        let currentData = {};

        // Confirmation modal handling
        function showConfirmation(title, message, onConfirm) {
            document.getElementById('confirm-title').textContent = title;
            document.getElementById('confirm-message').textContent = message;
            
            const modal = document.getElementById('confirm-modal');
            const cancelBtn = document.getElementById('confirm-cancel');
            const okBtn = document.getElementById('confirm-ok');
            
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            
            cancelBtn.onclick = () => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            };
            
            okBtn.onclick = () => {
                onConfirm();
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            };
        }

        function openPopup(type) {
            const popup = document.getElementById(`popup-${type}`);
            const loading = document.getElementById(`loading-${type}`);
            const content = document.getElementById(`content-${type}`);
            
            // Show popup with loading state
            popup.classList.remove('hidden');
            popup.classList.add('flex');
            loading.classList.remove('hidden');
            content.classList.add('hidden');
            
            // Fetch data
            fetch(`${BASE}/data/${type}`)
                .then(res => res.json())
                .then(data => {
                    currentData[type] = data;
                    renderTable(type, data);
                    
                    // Update count
                    document.getElementById(`${type}-count`).textContent = `${data.length} ${type}`;
                    
                    // Hide loading, show content
                    setTimeout(() => {
                        loading.classList.add('hidden');
                        content.classList.remove('hidden');
                    }, 500); // Small delay for better UX
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                    loading.innerHTML = `
                        <div class="text-center">
                            <i class="fas fa-exclamation-triangle text-red-500 text-3xl mb-3"></i>
                            <p class="text-red-400">Failed to load data</p>
                            <button onclick="openPopup('${type}')" class="mt-4 px-4 py-2 bg-gray-700 hover:bg-gray-600 rounded-lg text-white">
                                Try Again
                            </button>
                        </div>
                    `;
                });
                
            // Set up search functionality
            const searchInput = document.getElementById(`search-${type}`);
            searchInput.value = '';
            searchInput.onkeyup = () => {
                const searchTerm = searchInput.value.toLowerCase();
                const filteredData = currentData[type].filter(item => {
                    return Object.values(item).some(val => 
                        val && val.toString().toLowerCase().includes(searchTerm)
                    );
                });
                
                renderTable(type, filteredData);
                
                // Show/hide no results message
                const noResults = document.getElementById(`no-results-${type}`);
                if (filteredData.length === 0) {
                    noResults.classList.remove('hidden');
                    document.querySelector(`table`).classList.add('hidden');
                } else {
                    noResults.classList.add('hidden');
                    document.querySelector(`table`).classList.remove('hidden');
                }
            };
            
            // Set up filter functionality for users
            if (type === 'users') {
                const filterSelect = document.getElementById(`filter-${type}`);
                filterSelect.value = 'all';
                filterSelect.onchange = () => {
                    const filterValue = filterSelect.value;
                    let filteredData = currentData[type];
                    
                    if (filterValue !== 'all') {
                        filteredData = filteredData.filter(item => 
                            item.role && item.role.toLowerCase() === filterValue
                        );
                    }
                    
                    renderTable(type, filteredData);
                };
            }
        }

        function closePopup(type) {
            const popup = document.getElementById(`popup-${type}`);
            popup.classList.add('hidden');
            popup.classList.remove('flex');
        }

        function renderTable(type, data) {
            const table = document.getElementById(`${type}-table`);
            const header = document.getElementById(`${type}-header`);
            table.innerHTML = '';
            header.innerHTML = '';

            if (data.length === 0) {
                const noResults = document.getElementById(`no-results-${type}`);
                noResults.classList.remove('hidden');
                return;
            }

            // Render header
            const keys = Object.keys(data[0]).filter(k => k !== 'password');
            header.innerHTML = keys.map(k => 
                `<th class="px-4 py-3 text-left font-medium">${k.charAt(0).toUpperCase() + k.slice(1)}</th>`
            ).join('') + '<th class="px-4 py-3 text-right">Actions</th>';

            // Render rows
            data.forEach(item => {
                let row = '<tr class="hover:bg-[#2a2a2a] transition-colors">';
                
                keys.forEach(k => {
                    if (k === 'id') {
                        row += `<td class="px-4 py-3 font-medium">#${item[k]}</td>`;
                    } else if (k === 'role' || k === 'status') {
                        const colorClass = 
                            item[k] === 'admin' ? 'bg-red-900 text-red-200' :
                            item[k] === 'musician' ? 'bg-blue-900 text-blue-200' :
                            item[k] === 'active' ? 'bg-green-900 text-green-200' :
                            'bg-gray-800 text-gray-200';
                        
                        row += `<td class="px-4 py-3">
                            <span class="px-2 py-1 rounded-full text-xs ${colorClass}">
                                ${item[k]}
                            </span>
                        </td>`;
                    } else {
                        row += `<td class="px-4 py-3">${item[k] || '-'}</td>`;
                    }
                });

                if (type === 'users') {
                    row += `<td class="px-4 py-3 text-right space-x-2">
                        <button onclick="setMusician(${item.id})" 
                                class="px-2 py-1 bg-blue-600 hover:bg-blue-500 rounded text-xs inline-flex items-center gap-1 transition-colors">
                            <i class="fas fa-user-tag"></i> Set Musician
                        </button>
                        <button onclick="deleteUser(${item.id})" 
                                class="px-2 py-1 bg-red-600 hover:bg-red-500 rounded text-xs inline-flex items-center gap-1 transition-colors">
                            <i class="fas fa-trash-alt"></i> Delete
                        </button>
                    </td>`;
                }

                if (type === 'songs') {
                    row += `<td class="px-4 py-3 text-right">
                        <button onclick="deleteSong(${item.id})" 
                                class="px-2 py-1 bg-red-600 hover:bg-red-500 rounded text-xs inline-flex items-center gap-1 transition-colors">
                            <i class="fas fa-trash-alt"></i> Delete
                        </button>
                    </td>`;
                }

                if (type === 'playlists') {
                    row += `<td class="px-4 py-3 text-right">
                        <button onclick="deletePlaylist(${item.id})" 
                                class="px-2 py-1 bg-red-600 hover:bg-red-500 rounded text-xs inline-flex items-center gap-1 transition-colors">
                            <i class="fas fa-trash-alt"></i> Delete
                        </button>
                    </td>`;
                }
                
                row += '</tr>';
                table.innerHTML += row;
            });
        }

        function deleteUser(id) {
            showConfirmation(
                "Delete User", 
                "Are you sure you want to delete this user? This action cannot be undone.",
                () => {
                    fetch(`${BASE}/delete-user/${id}`, { method: 'POST' })
                        .then(() => openPopup('users'))
                        .catch(error => {
                            console.error('Error deleting user:', error);
                            alert('Failed to delete user. Please try again.');
                        });
                }
            );
        }

        function setMusician(id) {
            showConfirmation(
                "Set as Musician", 
                "Are you sure you want to set this user as a musician?",
                () => {
                    fetch(`${BASE}/set-musician/${id}`, { method: 'POST' })
                        .then(() => openPopup('users'))
                        .catch(error => {
                            console.error('Error setting musician:', error);
                            alert('Failed to set user as musician. Please try again.');
                        });
                }
            );
        }

        function deleteSong(id) {
            showConfirmation(
                "Delete Song", 
                "Are you sure you want to delete this song? This action cannot be undone.",
                () => {
                    fetch(`${BASE}/delete-song/${id}`, { method: 'POST' })
                        .then(() => openPopup('songs'))
                        .catch(error => {
                            console.error('Error deleting song:', error);
                            alert('Failed to delete song. Please try again.');
                        });
                }
            );
        }

        function deletePlaylist(id) {
            showConfirmation(
                "Delete Playlist", 
                "Are you sure you want to delete this playlist? This action cannot be undone.",
                () => {
                    fetch(`${BASE}/delete-playlist/${id}`, { method: 'POST' })
                        .then(() => openPopup('playlists'))
                        .catch(error => {
                            console.error('Error deleting playlist:', error);
                            alert('Failed to delete playlist. Please try again.');
                        });
                }
            );
        }
    </script>
</body>
</html>