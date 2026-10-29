# Lost and Found Management System

A PHP and MySQL web application for reporting and managing lost or found items. Users can create accounts, post item details with images, browse listings, and manage their own posts.

## Features

- User registration and login with password hashing
- Add lost or found item listings with an image, location, and description
- Browse listings through a dashboard
- View and manage your own listings
- Edit/delete your own listings and mark items as resolved
- Pagination for item listings
- MySQL-backed data persistence

## Tech stack

- **Frontend:** HTML and CSS
- **Backend:** PHP
- **Database:** MySQL
- **Local development:** XAMPP (Apache and MySQL)

## Run locally with XAMPP

1. Start **Apache** and **MySQL** in XAMPP.
2. Copy the project folder into the `htdocs` directory, for example `C:\\xampp\\htdocs\\lost-and-found-management-system`.
3. Open phpMyAdmin at `http://localhost/phpmyadmin`.
4. Create a database named `lost_and_found` and import [`database.sql`](database.sql).
5. Check `config/db.php`. The default values are `localhost`, database `lost_and_found`, user `root`, and an empty password for a standard local XAMPP setup. Change them to match your local MySQL configuration.
6. Ensure PHP can write to the `uploads` folder so images can be uploaded.
7. Open `http://localhost/lost-and-found-management-system/` in your browser. If needed, open `start.php` for the start page.
8. Register an account, sign in, and add a lost/found listing.

## Project structure

```text
lost-and-found/
├── auth/                 # Login, signup, and logout handlers
├── config/               # Database connection
├── dashboard/            # Dashboard and item management pages
├── uploads/              # Runtime image uploads (not tracked)
├── database.sql          # Database schema
├── index.php             # Main entry page
├── logo.svg               # Start page logo
├── login_form.php        # Login form
├── signup_form.php       # Signup form
└── start.php             # Start page
```

## Notes

- This is a locally run PHP/MySQL project, not a hosted live website.
- Uploaded item images are excluded from Git to avoid committing potentially personal photos.
- Do not commit real passwords, private data, or production credentials.
- Test the project locally before deploying it to a public server.

## Author

**Furkan Saifi**
