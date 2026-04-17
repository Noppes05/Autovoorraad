
# Autovoorraad
[![Ask DeepWiki](https://devin.ai/assets/askdeepwiki.png)](https://deepwiki.com/Noppes05/Autovoorraad)

Autovoorraad is a multi-tenant car platform where car companies can list vehicles for sale, and customers can browse the inventory for each company.

## About The Project

This application is built with the Laravel framework, featuring a complete authentication system scaffolded with Laravel Breeze. It serves as the foundation for a multi-tenant platform tailored for car dealerships. The front-end is styled with Tailwind CSS and uses Alpine.js for interactivity, all compiled with Vite.

### Key Features

*   **User Authentication**: A complete, secure authentication system including user registration, login, password reset, and email verification.
*   **Profile Management**: Registered users can update their profile information and password.
*   **Multi-tenant Foundation**: The core concept is designed for car companies to manage their own vehicle listings.
*   **Modern Tooling**: Built with Laravel 13, Vite, and Tailwind CSS.
*   **GSAP Integration**: Includes GSAP for creating rich animations and interactive experiences.

# 🔐 Threat Mitigation – Autovoorraad

## 📌 Algemene informatie

**Project:** Autovoorraad  
**Threat ID:**  T1 
**Naam threat:** Tenant Data Leak  
**STRIDE categorie:** Information Disclosure

---

## ⚠️ Probleem

Beschrijf hier kort het probleem:

Door het ontbreken van filtering op tenant/user kan data van andere tenants zichtbaar worden.

---

## 🎯 Doel van de mitigatie

 voorkomen dat gebruikers data van andere tenants kunnen zien.

---

## 🛠️ Implementatie

### 📁 Bestanden
- [Pad naar bestand 1]
- [Pad naar bestand 2]

Bijvoorbeeld:
- `App/Http/Controller/AutoAPIController.php`
- `App/Http/Controller/AutoAPIGetController.php`
- `App/Http/Controller/AutoController.php`
- `App/Actions/StoreNewAuto.php`
- `App/Actions/UpdateCar.php`


---

### 💻 Code-aanpassing

```php
// Voeg hier je relevante code snippet toe

bij alle acties word er gecheckt of de ingelogde user de user is van de auto die hij wil bekijken/aanpassen.
bijvoorbeeld in de `App/Http/Controller/AutoController.php`: ```
 $auto = Auto::where('id', $id)
            ->where('user_id', request()->user()->id)
            ->with(['fotos' => function ($query) {
                $query->orderBy('volgorde_nummer');
            }])
            ->firstOrFail();```


## Getting Started

Follow these steps to get a local copy up and running.

### Prerequisites

You will need the following software installed on your machine:
*   PHP >= 8.3
*   Composer
*   Node.js and npm

### Installation

1.  **Clone the repository:**
    ```sh
    git clone https://github.com/Noppes05/Autovoorraad.git
    ```

2.  **Navigate to the project directory:**
    The main Laravel application is located inside the `Autovoorraad/` subdirectory.
    ```sh
    cd Autovoorraad/Autovoorraad
    ```

3.  **Install dependencies:**
    This project includes a convenient setup script in `composer.json` which will install PHP and JS dependencies, create your `.env` file, generate an app key, and run migrations.
    ```sh
    composer setup
    ```
    *Alternatively, you can run the steps manually:*
    ```sh
    composer install
    npm install
    cp .env.example .env
    php artisan key:generate
    ```

4.  **Configure your environment:**
    Open the `.env` file and set your database credentials (`DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`, etc.).

5.  **Run database migrations:**
    ```sh
    php artisan migrate
    ```

## Usage

To run the development server, Vite, and the queue worker simultaneously, you can use the `dev` script defined in `composer.json`.

```sh
composer dev
```

This will start:
*   The Laravel development server (usually on `http://127.0.0.1:8000`)
*   The queue listener
*   The Vite server for hot module replacement

You can then access the application in your browser.

## Running Tests

To run the application's feature and unit tests, use the following Artisan command:

```sh
php artisan test
```

Or use the composer script alias:

```sh
composer test
