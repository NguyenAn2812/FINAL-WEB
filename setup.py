import os

project_structure = {
    "app/controllers": ["HomeController.php", "AuthController.php", "SongController.php", "PlaylistController.php", "UserController.php"],
    "app/models": ["User.php", "Song.php", "Playlist.php", "Like.php"],
    "app/views/auth": ["login.php", "register.php"],
    "app/views/songs": ["songcard.php","listsongs.php"],
    "app/views/user": ["profile.php"],
    "app/views/playlist": ["list.php","playlistdisplay.php","playlistcard.php"],
    "app/views/layouts": ["navbar.php", "controllerbar.php","songcontainer.php", "playlistcontainer.php","upload.php"],
    "public/assets/css": ["style.css"],
    "public/assets/js": ["script.js"],
    "public/uploads": [],
    "public/uploads/songs": [],
    "public/uploads/avatar": [],
    "core": ["App.php", "Controller.php", "Database.php"],
    ".": ["config.php", ".htaccess"],
    "public": ["index.php"]
}

def create_structure(base_path=""):
    for folder, files in project_structure.items():
        full_folder_path = os.path.join(base_path, folder)
        os.makedirs(full_folder_path, exist_ok=True)
        print(f"✔ Folder: {full_folder_path}")
        for file in files:
            file_path = os.path.join(full_folder_path, file)
            open(file_path, 'w').close()
            print(f"   └── Create file: {file_path}")
if __name__ == "__main__":
    create_structure()
