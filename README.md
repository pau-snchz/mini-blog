# Mini Blog

<p align="center">
  <img src="public/images/mug&munch-logo.png" alt="Mug & Munch Logo" width="300">
</p>

A mini-blog web application built with Laravel and TailwindCSS designed for a personal cafe enthusiast and food spot hunter. This platform allows the blogger to share their cafe discoveries, featuring detailed reviews with their top drink and food choices, along with comprehensive scoring for affordability, ambiance, and taste on a 1-10 scale.

## Features

- 🚀 Built with Laravel 12.0
- 🎨 Styled with TailwindCSS 4.0
- ☕ Personal cafe-focused blog
- 🍴 Food spot hunting and reviews
- 📊 Scoring system for affordability, ambiance, and taste (1-10 scale)
- 🥤 Top drink and food choice recommendations
- 📱 Responsive design
- ⚡ Vite for fast development and building
- 🔧 Modern PHP 8.2+ support
- 🧪 Built-in testing with PHPUnit

## Requirements

- PHP 8.2 or higher
- Composer
- Node.js and npm
- MySQL 8.0+ or MariaDB 10.3+
- Web server (Apache/Nginx)

## Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/pau-snchz/mini-blog.git
   cd mini-blog
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install Node.js dependencies**
   ```bash
   npm install
   ```

4. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Database setup**
   
   Create a MySQL database for the project:
   ```sql
   CREATE DATABASE mini_blog;
   ```
   
   Update your `.env` file with MySQL credentials:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=mini_blog
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

6. **Run migrations**
   ```bash
   php artisan migrate
   ```

7. **Seed the database (optional)**
   ```bash
   # Run all seeders
   php artisan db:seed
   ```

8. **Build assets**
   ```bash
   npm run build
   ```

## Development

### Quick Start
Run the application in development mode with hot reloading:

```bash
composer run dev
```

This command will start:
- Laravel development server (`php artisan serve`)
- Queue worker (`php artisan queue:listen`)
- Vite development server (`npm run dev`)

### Individual Commands

**Start the Laravel server:**
```bash
php artisan serve
```

**Run Vite development server:**
```bash
npm run dev
```

**Build assets for production:**
```bash
npm run build
```

### Seeding Data

The application includes database seeders to populate initial data:

```bash
# Fresh migration with seeding
php artisan migrate:fresh --seed

# Reset database and seed
php artisan db:seed

# Refresh specific seeder
php artisan db:seed --class=PostSeeder
```
