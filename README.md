---

## 👤 Author

**Chijindu Nwokeohuru**  
Email: chijindu.nwokeohuru@gmail.com

# TaskManager CoalitionTech

A modern, business-ready Laravel web application for project and task management. Features include modal-based CRUD, drag-and-drop, Toastr notifications, search, filtering, and a beautiful Tailwind CSS UI.

---

## 🚀 Features

- **Project & Task Management**: Create, edit, delete, and view projects and tasks with modal dialogs and AJAX.
- **Drag-and-Drop Tasks**: Reorder tasks within a project using SortableJS; priorities update automatically.
- **Search & Filter**: Search tasks by name and filter by project. Search projects by name.
- **Pagination**: Both projects and tasks are paginated (5 per page).
- **Toastr Notifications**: Instant feedback for CRUD actions and confirmations.
- **Responsive UI**: Built with Tailwind CSS for a modern, mobile-friendly experience.
- **Demo Data**: Realistic business projects and tasks seeded for demo purposes.

---

## 🛠️ Setup & Local Development

1. **Clone the repository**
	```sh
	git clone <your-repo-url>
	cd taskmanager_coalitionTech
	```

2. **Install PHP dependencies**
	```sh
	composer install
	```

3. **Install Node.js dependencies**
	```sh
	npm install
	```

4. **Copy and configure environment**
	```sh
	cp .env.example .env
	# Edit .env and set DB_DATABASE, DB_USERNAME, DB_PASSWORD, etc.
	```

5. **Generate application key**
	```sh
	php artisan key:generate
	```

6. **Run migrations and seeders**
	```sh
	php artisan migrate --seed
	```

7. **Build frontend assets**
	```sh
	npm run build
	# Or for development: npm run dev
	```

8. **Start the local server**
	```sh
	php artisan serve
	```

9. **Access the app**
	- Visit [http://127.0.0.1:8000](http://127.0.0.1:8000).

---

## 🌐 Deployment

1. **Upload all files to your server**
2. **Install dependencies**
	- `composer install --optimize-autoloader --no-dev`
	- `npm install && npm run build`
3. **Set up your `.env` file** (database, app key, etc.)
4. **Run migrations and seeders**
	- `php artisan migrate --seed --force`
5. **Set correct permissions** for `storage/` and `bootstrap/cache/`
6. **Point your web server to the `/public` directory**
7. **(Optional) Optimize for production**
	- `php artisan config:cache`
	- `php artisan route:cache`
	- `php artisan view:cache`

---

## 📝 Project Structure

- `app/Http/Controllers/` — Laravel controllers for projects and tasks
- `app/Models/` — Eloquent models
- `database/migrations/` — Database schema
- `database/seeders/` — Seeders for demo data
- `database/factories/` — Factories for generating fake data
- `resources/views/` — Blade templates (Tailwind CSS, modals, AJAX)
- `public/` — Entry point for web server
- `package.json` — Frontend tooling (Vite, Tailwind CSS)
- `composer.json` — PHP dependencies

---

## 🧪 Testing

Run all tests:

```sh
php artisan test
```

---

## 🤝 Credits

Created by Chijindu Nwokeohuru for CoalitionTech. Built with Laravel, Tailwind CSS, Toastr, and SortableJS.

---

## 📄 License

This project is open-sourced under the MIT license.
