# BersihQ Management System

## Description
BersihQ Management System is a web application built with Laravel to manage cleaning service orders, customers, services, and WhatsApp integration for notifications.

## Features
- Customer Management
- Service Management
- Order Management
- Transaction Reports
- WhatsApp Integration for notifications
- User Management with role differentiation (Admin, Kasir)

## Installation
1. Clone the repository: `git clone https://github.com/your-username/bersihq.git`
2. Navigate to the project directory: `cd bersihq`
3. Install PHP dependencies: `composer install`
4. Install JavaScript dependencies: `npm install`
5. Copy the environment file: `cp .env.example .env`
6. Generate an application key: `php artisan key:generate`
7. Configure your database in the `.env` file.
8. Run database migrations: `php artisan migrate --seed` (the `--seed` flag will run seeders to populate initial data)
9. Start the development server: `php artisan serve`
10. If you are using `npm run dev` for asset compilation, run it in a separate terminal: `npm run dev`

## Usage
- Access the application in your web browser at the address provided by `php artisan serve` (usually `http://127.0.0.1:8000`).
- Log in with the appropriate credentials:
    - **Admin**: Access to all features including user management and WhatsApp configuration.
    - **Kasir**: Access to order management, customer management, and service management.

## WhatsApp Integration
- Configure WhatsApp API settings via the Admin dashboard.
- Templates for WhatsApp messages can be managed within the application.
- Ensure your WhatsApp service/API (e.g., Fonnte) is active and correctly configured.

## Contributing
Contributions are welcome! Please follow these steps:
1. Fork the repository.
2. Create a new branch (`git checkout -b feature/your-feature-name`).
3. Make your changes.
4. Commit your changes (`git commit -m 'Add some feature'`).
5. Push to the branch (`git push origin feature/your-feature-name`).
6. Open a Pull Request.
