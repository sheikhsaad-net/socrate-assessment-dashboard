# Socrate Assessment Dashboard

Socrate is a web application for reviewing user responses and activity collected through the Socrate experience. The authenticated dashboard brings together user records, question and survey responses, exercises, activity tracks, and CSV exports.

## Features

- Authenticated dashboard for reviewing users and collected data
- Browse survey questions and pre- and post-survey responses
- Review exercise answers and activity tracks
- Export user and exercise data to CSV
- Manage user records

## Technology

- PHP 8.2+
- Laravel 12
- Laravel Jetstream, Livewire 3, and Sanctum
- Vite and Tailwind CSS

## Local setup

1. Install PHP dependencies:

   ```bash
   composer install
   ```

2. Create a `.env` file in the project root and configure the application key, database connection, and other local settings. This repository currently does not include an `.env.example` file.

3. Generate an application key:

   ```bash
   php artisan key:generate
   ```

4. Create the configured database, then run migrations:

   ```bash
   php artisan migrate
   ```

5. Install JavaScript dependencies and build the frontend:

   ```bash
   npm install
   npm run build
   ```

6. Start the Laravel development server:

   ```bash
   php artisan serve
   ```

Open the URL printed by Artisan. For local development with live asset rebuilding, use `npm run dev` in a separate terminal.

## Data and privacy

The application handles user accounts, answers, survey responses, and activity records. Configure access, database credentials, backups, and retention practices appropriately for the environment where it is deployed. Do not commit `.env` or real user data.

## License

No project-specific license is currently declared. Add a `LICENSE` file before distributing or reusing this project publicly.
