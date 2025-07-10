# Camion des Saveurs - Back-end

A Symfony-based backend API for managing a food truck business, including menu management, order processing, and customer management.

## Features

- **Menu Management**: Create and manage food items with descriptions, prices, categories, and availability
- **Order Processing**: Handle customer orders with order items, status tracking, and notes
- **User Management**: Customer accounts with authentication and order history
- **CSRF Protection**: Built-in security features for form submissions

## Tech Stack

- **PHP 8.x** with Symfony framework
- **PostgreSQL** database
- **Doctrine ORM** for database management
- **Stimulus** for frontend interactivity
- **Asset Mapper** for asset management
- **Docker** support with compose files

## Project Structure

```
src/
├── Entity/           # Database entities (User, Order, Menu, OrderItem)
├── Repository/       # Database repositories
├── Controller/       # API controllers
└── Kernel.php       # Symfony kernel

assets/
├── controllers/     # Stimulus controllers
├── styles/         # CSS files
└── app.js          # Main JavaScript entry point

migrations/         # Database migrations
templates/          # Twig templates
```

## Getting Started

### Prerequisites

- PHP 8.x
- Composer
- PostgreSQL
- Docker (optional)

### Installation

1. Clone the repository
2. Install dependencies:
   ```bash
   composer install
   ```

3. Set up environment variables:
   ```bash
   cp .env .env.local
   # Edit .env.local with your database credentials
   ```

4. Create and migrate the database:
   ```bash
   php bin/console doctrine:database:create
   php bin/console doctrine:migrations:migrate
   ```

5. Start the development server:
   ```bash
   symfony server:start
   ```

### Using Docker

Alternatively, use Docker Compose:

```bash
docker-compose up -d
```

## Database Schema

The application includes the following main entities:

- **[`User`](src/Entity/User.php)**: Customer accounts with authentication
- **[`Menu`](src/Entity/Menu.php)**: Food items with pricing and availability
- **[`Order`](src/Entity/Order.php)**: Customer orders with status tracking
- **`OrderItem`**: Individual items within an order

## Development

### Running Tests

```bash
php bin/phpunit
```

### Asset Management

Assets are managed using Symfony's Asset Mapper. The main entry point is [`assets/app.js`](assets/app.js).

### Database Migrations

Create new migrations:
```bash
php bin/console make:migration
```

Apply migrations:
```bash
php bin/console doctrine:migrations:migrate
```

## API Endpoints

The application provides RESTful API endpoints for:
- Menu management
- Order processing
- User authentication
- Customer management

## Security

The application includes:
- CSRF protection via [`assets/controllers/csrf_protection_controller.js`](assets/controllers/csrf_protection_controller.js)
- User authentication and authorization
- Secure password handling

## Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Run tests
5. Submit a pull request

## License

[Add your license information here]