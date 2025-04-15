# FINAL-WEB
# 🎵 Music Library Project – Team Task

This is a YouTube Music-style web application built with PHP + Bootstrap using the MVC architecture. Below is the task allocation by functional groups.
---

## ✅ Combo 1 – Backend & Core Logic

### 1. Project Structure & Initialization
- Set up folder and file structure based on MVC pattern
- Implement `core/App.php`, `Controller.php`, `Database.php`
- Create base configuration files: `config.php`, `.htaccess`

### 2. Database Design & Models
- Design and create the following tables:
  - `users`, `songs`, `playlists`, `likes`, `playlist_songs`
- Create model classes: `User.php`, `Song.php`, `Playlist.php`, `Like.php`

### 3. Controllers & Application Logic
- `AuthController.php`: register, login, logout
- `SongController.php`: uploading and playing music
- `PlaylistController.php`: creating playlists, play playlist
- `UserController.php`: user profile and uploaded songs

### 4. Advanced Features
- Like / Unlike songs
- Display like count, check like status
- Shuffle (random) song playback
- Continuous playlist playback

---

## ✅ Combo 2 – Frontend & UI/UX

### 1. Layout & Structure
- Build main layout files: `header.php`, `footer.php`
- Ensure responsive design using Bootstrap 5

### 2. User Interface Pages
- Auth: `auth/login.php`, `auth/register.php`
- Songs: `songs/list.php`, `songs/play.php`, `songs/upload.php`
- Playlists: `playlist/index.php`, `playlist/play.php`
- User profile: `user/profile.php`

### 3. Music Player Implementation
- Use `<audio>` HTML element with buttons:
  - Play / Pause
  - Next / Previous
  - Shuffle
- Use JavaScript to control audio behavior

---

## ✅ Combo 3 – Testing & Sample Data

### 1. Sample Data Setup
- Upload a few demo songs into `public/uploads/`
- Create sample playlists for testing
- Manually assign songs to playlists (via interface or SQL)

### 2. Feature Testing
- Test registration and login flows
- Test song upload and playback
- Test like / unlike functionality
- Test playlist creation and playback
- Verify correct display of user profile and song lists

### 3. Documentation & QA Checklist
- Create a checklist for tested features
- Write a simple user guide in `README.md`
- Record any bugs and suggest UI/UX improvements

---

## 📌 Git Collaboration Guidelines

- Each combo works on its own Git branch:
  - `combo1-backend`, `combo2-frontend`, `combo3-testing`
- Merge into `main` after successful testing
- Use clear commit messages:
  - `feat: add playlist logic`, `fix: adjust song card layout`

---

