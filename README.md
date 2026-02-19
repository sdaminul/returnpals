# ReturnPal

A comprehensive package management and returns processing system built with Laravel 10 and Vite.

## Product Overview

ReturnPal is a web-based platform designed to help businesses manage returned products efficiently. It provides tools for tracking packages from shipment to processing, managing inventory, creating invoices, and generating reports.

### Key Features

- **Package Management**: Track packages through their entire lifecycle (In Transit → Received → Processing → Processed)
- **Product Tracking**: Detailed tracking of individual products within packages
- **Pending Items**: Monitor items currently being processed with stage tracking
- **Sold Items**: Track sold products with revenue and profit analytics
- **Invoice Management**: Generate and download invoices
- **User Settings**: Configure VAT settings and Discord webhook notifications
- **Role-Based Access**: Admin and Operator roles with appropriate permissions
- **Bulk Upload**: Import packages from CSV/XLSX files

## User Roles

### Admin
- Full access to all features
- Can view and modify any user's data
- Can manage all packages, items, and invoices across the system
- Access to administrative settings

### Operator
- Can manage their own packages and items
- Can view and create packages
- Can track pending and sold items
- Can generate invoices
- Limited to their own data

## Key User Flows

### 1. Send a Package
1. Navigate to Dashboard → Overview (Packages Sent)
2. Click "Add Package" button
3. Fill in package reference and optional notes
4. Add product items with name, quantity, condition, and notes
5. Submit to create package with "In Transit" status
6. Package appears in the sent packages list

### 2. View Received Packages
1. Navigate to Dashboard → Received
2. View all packages with status: Received, Processing, or Processed
3. Filter and search through received packages
4. View detailed package information and items

### 3. Track Pending Items
1. Navigate to Dashboard → Items Pending
2. View all items currently being processed
3. See processing stage and estimated completion date
4. Add notes to track progress

### 4. Manage Sold Items
1. Navigate to Dashboard → Sold Items
2. View all sold products with pricing and profit data
3. See summary cards with total revenue and profit
4. Track sales performance

### 5. Generate Invoice
1. Navigate to Dashboard → Invoices
2. View list of all invoices
3. Click "Download" on any invoice to generate HTML file
4. Invoice includes all relevant billing information

### 6. Configure Settings
1. Navigate to Dashboard → Settings
2. Toggle VAT registration status
3. Add Discord webhook URL for notifications
4. Save settings

## Setup Instructions

### Requirements
- PHP 8.1 or higher
- Composer
- Node.js 16+ and npm
- MySQL 5.7+ or SQLite (for testing)
- Git

### Local Development Setup

1. **Clone the repository**
   ```bash
   git clone https://github.com/sdaminul/returnpals.git
   cd returnpals
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install JavaScript dependencies**
   ```bash
   npm install
   ```

4. **Environment configuration**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Configure database**
   
   Edit `.env` file with your database credentials:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=returnpal
   DB_USERNAME=root
   DB_PASSWORD=
   ```

6. **Run migrations**
   ```bash
   php artisan migrate
   ```

7. **Seed database (optional)**
   ```bash
   php artisan db:seed
   ```
   
   This creates sample users and data:
   - Admin: admin@returnpals.com / password
   - Operator 1: operator1@returnpals.com / password
   - Operator 2: operator2@returnpals.com / password

8. **Build frontend assets**
   ```bash
   npm run build
   ```
   
   Or for development with hot reload:
   ```bash
   npm run dev
   ```

9. **Start the development server**
   ```bash
   php artisan serve
   ```
   
   Access the application at: http://127.0.0.1:8000

### Testing

Run the test suite:
```bash
php artisan test
```

Run specific test suites:
```bash
php artisan test --testsuite=Feature
php artisan test --testsuite=Unit
```

Run tests with coverage:
```bash
php artisan test --coverage
```

## Build Scripts

### Backend (Laravel)

- `composer install` - Install PHP dependencies
- `composer update` - Update PHP dependencies
- `php artisan migrate` - Run database migrations
- `php artisan migrate:fresh --seed` - Fresh database with seed data
- `php artisan test` - Run tests
- `php artisan serve` - Start development server

### Frontend (Vite/Vue)

- `npm install` - Install JavaScript dependencies
- `npm run dev` - Start Vite development server with hot reload
- `npm run build` - Build production assets
- `npm run lint` - Lint JavaScript/Vue files
- `npm run lint:fix` - Lint and auto-fix issues
- `npm run format` - Format code with Prettier
- `npm run format:check` - Check code formatting

### Code Quality

The project includes ESLint and Prettier configurations for maintaining code quality:

- **ESLint**: Configured for Vue 3 and ES2021
  - Rules: `.eslintrc.json`
  - Run: `npm run lint` or `npm run lint:fix`

- **Prettier**: Configured for consistent code formatting
  - Config: `.prettierrc.json`
  - Run: `npm run format` or `npm run format:check`

- **Laravel Pint**: PHP code style fixer (Laravel's opinionated wrapper around PHP-CS-Fixer)
  ```bash
  ./vendor/bin/pint
  ```

## Deployment

### Local Deployment (XAMPP/WAMP)

1. Place project in `htdocs` or web root directory
2. Create database in phpMyAdmin
3. Configure `.env` with database credentials
4. Run migrations: `php artisan migrate`
5. Build assets: `npm run build`
6. Access via: `http://localhost/returnpal/public`

### Production Deployment

1. **Server Requirements**
   - PHP 8.1+, MySQL 5.7+, Composer, Node.js
   - Apache/Nginx web server
   - SSL certificate (recommended)

2. **Deployment Steps**
   ```bash
   # Clone and navigate to project
   git clone https://github.com/sdaminul/returnpals.git
   cd returnpals
   
   # Install dependencies
   composer install --optimize-autoloader --no-dev
   npm ci
   
   # Configure environment
   cp .env.example .env
   # Edit .env with production settings
   php artisan key:generate
   
   # Database setup
   php artisan migrate --force
   
   # Build assets
   npm run build
   
   # Optimize
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   
   # Set permissions
   chmod -R 775 storage bootstrap/cache
   chown -R www-data:www-data storage bootstrap/cache
   ```

3. **Web Server Configuration**
   
   Point document root to `/public` directory.
   
   **Apache**: Create `.htaccess` in public directory (already included)
   
   **Nginx**: Example configuration:
   ```nginx
   server {
       listen 80;
       server_name returnpals.example.com;
       root /path/to/returnpals/public;
       
       index index.php index.html;
       
       location / {
           try_files $uri $uri/ /index.php?$query_string;
       }
       
       location ~ \.php$ {
           fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
           fastcgi_index index.php;
           fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
           include fastcgi_params;
       }
   }
   ```

4. **Environment Variables**
   
   Key production settings in `.env`:
   ```env
   APP_ENV=production
   APP_DEBUG=false
   APP_URL=https://your-domain.com
   
   DB_CONNECTION=mysql
   DB_HOST=your-db-host
   DB_DATABASE=your-db-name
   DB_USERNAME=your-db-user
   DB_PASSWORD=your-db-password
   ```

5. **Security Considerations**
   - Keep `.env` file secure and out of version control
   - Use strong database passwords
   - Enable HTTPS/SSL
   - Regular backups
   - Keep dependencies updated

## Screenshots

_Screenshots will be added here to demonstrate key features:_

- [ ] Dashboard Overview
- [ ] Package Management (Sent Packages)
- [ ] Received Packages List
- [ ] Pending Items Processing
- [ ] Sold Items with Analytics
- [ ] Invoice Generation
- [ ] Settings Configuration
- [ ] Bulk Upload Interface

## Data Model

_Data model diagram will be added here showing relationships between:_

- Users
- Packages
- Package Items
- Pending Items
- Sold Items
- Invoices
- User Settings

### Database Schema Overview

**Core Tables:**
- `users` - User accounts with roles (admin/operator)
- `packages` - Package tracking (reference, status, dates)
- `package_items` - Individual products within packages
- `pending_items` - Items currently being processed
- `sold_items` - Sold products with revenue tracking
- `invoices` - Generated invoices
- `user_settings` - User preferences (VAT, webhooks)

## Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

### Development Guidelines

- Follow Laravel best practices
- Write tests for new features
- Run linters before committing (`npm run lint:fix`, `./vendor/bin/pint`)
- Update documentation for new features

## License

This project is open-sourced software licensed under the MIT license.

## Support

For issues, questions, or contributions, please open an issue on GitHub or contact the development team.
