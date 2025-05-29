# 🎨 Teaser App – Laravel + Livewire v3 (TALL Stack)

![Teaser App Demo](./docs/demo.gif)

## 🇩🇪 Deutsch

Willkommen bei der **Teaser App**, einer Laravel-Anwendung, die auf dem **TALL Stack** basiert:

-   🧠 **Tailwind CSS**
-   ⚡ **Alpine.js**
-   🛠️ **Laravel**
-   🔄 **Livewire v3**

Mit dieser App können Benutzer kurze „Teaser“ einreichen, die Folgendes beinhalten:

-   Einen Titel
-   Eine Beschreibung (Text)
-   Ein hochgeladenes Bild mit Live-Vorschau

---

## 🚀 Funktionen

-   🖼️ Live-Vorschau für Bild-Uploads (Alpine.js + Livewire)
-   ✅ Formularvalidierung
-   💾 Speicherung der Bilder in `storage/app/public`
-   🔄 Interaktive Komponenten mit Livewire
-   📱 Responsives Design mit Tailwind CSS
-   🔐 Login/Registrierung für nutzerspezifische Inhalte

---

## ⚙️ Technologie-Stack

| Technologie  | Version          |
| ------------ | ---------------- |
| Laravel      | ^12.x            |
| Livewire     | ^3.6             |
| Tailwind CSS | ^3.x             |
| Alpine.js    | ^3.x (über Vite) |
| Vite         | ^6.x             |
| PHP          | ^8.2             |

---

## 🛠 Installation & Einrichtung

### 1. Repository klonen

```bash
git clone https://github.com/altinawiwaseem/Teaser_App.git
cd Teaser_App
```

### 2. Composer-Abhängigkeiten installieren

```bash
composer install
```

### 3. NPM-Abhängigkeiten installieren

```bash
npm install
```

### 4. `.env`-Datei erstellen und App-Schlüssel generieren

```bash
cp .env.example .env
php artisan key:generate
```

### 5. `.env` für die Datenbank konfigurieren

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=teaser_app
DB_USERNAME=root
DB_PASSWORD=
```

---

### 6. Migrationen ausführen

```bash
php artisan migrate
```

---

### 7. Storage-Link für Bilder erstellen

```bash
php artisan storage:link
```

---

### 8. Entwicklungsserver starten

```bash
npm run dev      # Startet Vite für Tailwind und JS
php artisan serve
```

App im Browser öffnen: [http://localhost:8000](http://localhost:8000)

---

## 👨‍💻 Autor

**Altinawi Waseem**  
🔗 [github.com/altinawiwaseem](https://github.com/altinawiwaseem)

---

## 🇬🇧 English

Welcome to the **Teaser App**, a Laravel application powered by the **TALL stack**:

-   🧠 **Tailwind CSS**
-   ⚡ **Alpine.js**
-   🛠️ **Laravel**
-   🔄 **Livewire v3**

This app allows users to submit short "teasers" that include:

-   A title
-   A description (text)
-   An uploaded image with a live preview

---

## 🚀 Features

-   🖼️ Live image upload preview (Alpine.js + Livewire)
-   ✅ Form validation
-   💾 Images stored via `storage/app/public`
-   🔄 Livewire-powered interactivity
-   📱 Responsive UI with Tailwind
-   🔐 login/registration for user-specific content

---

## ⚙️ Stack Details

| Technology   | Version         |
| ------------ | --------------- |
| Laravel      | ^12.x           |
| Livewire     | ^3.6            |
| Tailwind CSS | ^3.x            |
| Alpine.js    | ^3.x (via Vite) |
| Vite         | ^6.x            |
| PHP          | ^8.2            |

---

## 🛠 Installation & Setup

### 1. Clone the Repository

```bash
git clone https://github.com/altinawiwaseem/Teaser_App.git
cd Teaser_App
```

### 2. Install Composer Dependencies

```bash
composer install
```

### 3. Install NPM Dependencies

```bash
npm install
```

### 4. Create `.env` File & Set Key

```bash
cp .env.example .env
php artisan key:generate
```

### 4. Configure `.env` for Your Database

After copying `.env.example` to `.env`, update the following based on your database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=teaser_app
DB_USERNAME=root
DB_PASSWORD=
```

---

### 6. Run Migrations

```bash
php artisan migrate
```

---

### 7. Link the Storage for Uploaded Images

```bash
php artisan storage:link
```

---

### 8. Start Development Servers

```bash
npm run dev      # Runs Vite for Tailwind + JS
php artisan serve
```

Visit: [http://localhost:8000](http://localhost:8000)

---

## 👨‍💻 Author

**Altinawi Waseem**  
🔗 [github.com/altinawiwaseem](https://github.com/altinawiwaseem)
