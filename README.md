
# Library Management System API

## Overview
This project is a RESTful API for managing authors and books in a library system. It is implemented using **PHP** and the **Laravel Framework**, designed with clean code practices, efficient database design, and optimized performance.

---

## Features
### Authors
- Retrieve a list of all authors.
- Retrieve details of a specific author.
- Create a new author.
- Update an existing author.
- Delete an author.

### Books
- Retrieve a list of all books.
- Retrieve details of a specific book.
- Create a new book.
- Update an existing book.
- Delete a book.

### Associations
- Retrieve all books by a specific author.

---

## Technologies Used
- **Language:** PHP
- **Framework:** Laravel
- **Database:** MySQL
- **Testing Framework:** PHPUnit

---

## Installation

### Prerequisites
- PHP 7.4+
- Composer installed
- MySQL installed

### Setup Instructions
1. **Clone the Repository:**
   ```bash
   git clone https://github.com/yourusername/library-management-system.git
   cd library-management-system
   ```

2. **Install Dependencies:**
   ```bash
   composer install
   ```

3. **Configure the Database:**
   - Copy the `.env.example` file to `.env`:
     ```bash
     cp .env.example .env
     ```
   - Update the database credentials in the `.env` file:
     ```env
     DB_CONNECTION=mysql
     DB_HOST=127.0.0.1
     DB_PORT=3306
     DB_DATABASE=library_app
     DB_USERNAME=root
     DB_PASSWORD=yourpassword
     ```

4. **Run Migrations:**
   This command will create the database tables based on the migrations:
   ```bash
   php artisan migrate
   ```

5. **Seed the Database:**
   Seed the database with sample data using:
   ```bash
   php artisan db:seed --class=AuthorSeeder
   php artisan db:seed --class=BookSeeder
   ```

6. **Start the Server:**
   Run the Laravel development server:
   ```bash
   php artisan serve
   ```
   Now, the application is accessible at `http://localhost:8000`

---

## API Endpoints

### Authors
- **GET** `/authors` - Retrieve a list of all authors.
- **GET** `/authors/{id}` - Retrieve details of a specific author.
- **POST** `/authors` - Create a new author.
- **PUT** `/authors/{id}` - Update an existing author.
- **DELETE** `/authors/{id}` - Delete an author.

### Books
- **GET** `/books` - Retrieve a list of all books.
- **GET** `/books/{id}` - Retrieve details of a specific book.
- **POST** `/books` - Create a new book.
- **PUT** `/books/{id}` - Update an existing book.
- **DELETE** `/books/{id}` - Delete a book.

### Associations
- **GET** `/authors/{id}/books` - Retrieve all books by a specific author.

---

## Unit Tests

### Running Tests
1. **Ensure Database is Seeded:**
   Before running the tests, ensure that the database is seeded with sample data:
   ```bash
   php artisan db:seed --class=AuthorSeeder
   php artisan db:seed --class=BookSeeder
   ```

2. **Run the test suite:**
   ```bash
   ./vendor/bin/phpunit
   ```

---

## Performance Tuning
### Database Query Optimization
- Indexing frequently queried fields (e.g., `author_id` in the books table) improves the speed of read operations.
- Using `Eager Loading` to avoid N+1 query issues.

### Caching
- Implement caching for the **GET** endpoints for books and authors using Laravel’s built-in caching system. This will help improve response times for frequent requests, reducing the need for repeated database queries.

---

## Design Choices
1. **Model Relationships:**
   - One-to-many relationship between authors and books (one author can write many books).

2. **Database Schema:**
   - `authors`: `id`, `name`, `bio`, `birth_date`
   - `books`: `id`, `title`, `description`, `publish_date`, `author_id` (foreign key)

3. **Caching Strategy:**
   - The **GET** requests for authors and books will be cached to reduce database load.

4. **Performance Considerations:**
   - As the number of books and authors grows, pagination will be necessary for the `/books` and `/authors` endpoints to avoid loading all records at once.

---

## License
This project is licensed under the MIT License.
