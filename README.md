# Restaurant Management System

A comprehensive restaurant management system built with Laravel 12 and Tailwind CSS, featuring client and admin authentication, table booking, and food ordering.

## Features

### 🔐 Authentication
- **Client Registration/Login**: Customers can register and login to book tables and place orders
- **Admin Authentication**: Restaurant staff can login with admin privileges
- **Role-based Access Control**: Different interfaces for clients and admins

### 🍽️ Food Ordering System
- **Menu Browsing**: Public menu with categoried items (appetizers, main courses, desserts, beverages)
- **Order Management**: Clients can add items to their cart and place orders
- **Order Tracking**: Real-time order status updates
- **Admin Order Management**: Staff can view and manage customer orders

### 📅 Table Booking System
- **Table Reservation**: Clients can book available tables for specific dates and times
- **Table Management**: Admins can manage table availability and capacity
- **Booking Validation**: Automatic validation for party size vs table capacity
- **Booking Status Tracking**: Pending, confirmed, cancelled, and completed statuses

### 🎨 UI/UX Design
- **Responsive Design**: Mobile-first design using Tailwind CSS
- **Attractive Interface**: Modern, clean design with orange/red color scheme
- **Public Pages**: Homepage and menu accessible without authentication
- **Dashboard Views**: Separate dashboards for clients and admins

## Installation

### Prerequisites
- PHP 8.4+
- MySQL 5.7+
- Composer
- Node.js & NPM

### Setup Instructions

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd restaurant-management
   ```

2. **Install dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Database configuration**
   - Update your `.env` file with database credentials
   - Run migrations and seeders:
   ```bash
   php artisan migrate:fresh --seed
   ```

5. **Build assets**
   ```bash
   npm run build
   # OR for development:
   npm run dev
   ```

6. **Start the server**
   ```bash
   php artisan serve
   ```

## Default Access

### Admin Account
- **Email**: admin@restaurant.com
- **Password**: password
- **Role**: Admin

### Sample Data
The seeder creates:
- 1 restaurant (Delicious Restaurant)
- 6 tables with different capacities
- 15+ menu items across 4 categories
- All necessary database relationships

## Project Structure

```
├── app/
│   ├── Http/Controllers/
│   │   ├── BookingController.php      # Table booking management
│   │   ├── DashboardController.php    # Dashboard logic
│   │   ├── MenuController.php         # Public menu
│   │   ├── OrderController.php        # Food ordering
│   │   └── PublicController.php       # Public pages
│   ├── Http/Middleware/
│   │   └── CheckRole.php              # Role-based access
│   └── Models/
│       ├── Booking.php                # Reservation model
│       ├── Meal.php                   # Menu item model
│       ├── Order.php                  # Order model
│       ├── Restaurant.php             # Restaurant model
│       ├── Table.php                  # Table model
│       └── User.php                   # Enhanced user model
├── database/
│   ├── migrations/                    # Database schema
│   └── seeders/                       # Sample data
├── resources/views/
│   ├── layouts/                       # Page layouts
│   ├── public/                        # Public pages
│   ├── dashboard/                     # Dashboard views
│   └── bookings/                      # Booking forms
└── routes/web.php                     # Application routes
```

## Key Features in Detail

### 🔒 Security
- CSRF protection on all forms
- Role-based middleware for route protection
- User authentication with Laravel Breeze
- Input validation and sanitization

### 📱 Responsive Design
- Mobile-first approach
- Touch-friendly interface
- Collapsible navigation menu
- Optimized images and layout

### 🗄️ Database Design
- Proper relationships between models
- Foreign key constraints
- Optimized for MySQL with key length fixes
- Seed data for immediate testing

### 🎯 User Experience
- Intuitive navigation
- Clear status indicators
- Form validation with helpful error messages
- Success/warning message system

## Usage

### For Clients
1. **Browse Menu**: Visit the public menu to see all available items
2. **Book Table**: Register/login and create a table reservation
3. **Place Orders**: Add items to cart and place orders
4. **Track Orders**: Monitor order status in your dashboard

### For Admins
1. **Access Admin Panel**: Login with admin credentials
2. **Manage Bookings**: Accept/reject customer reservations
3. **Process Orders**: Update order statuses as they progress
4. **Restaurant Management**: Manage tables, menu items, and restaurant info

## Development

### Running Tests
```bash
php artisan test
```

### Laravel Commands
```bash
# Create new models with migrations
php artisan make:model ModelName -m

# Generate controllers
php artisan make:controller ControllerName --resource

# Create middleware
php artisan make:middleware MiddlewareName
```

### Asset Compilation
```bash
# Development (with hot reload)
npm run dev

# Production build
npm run build
```

## Technologies Used

- **Backend**: Laravel 12, PHP 8.4
- **Frontend**: Blade Templates, Tailwind CSS, Alpine.js
- **Database**: MySQL
- **Authentication**: Laravel Breeze
- **Build Tools**: Vite

## Contributing

1. Fork the repository
2. Create a feature branch
3. Commit your changes
4. Push to the branch
5. Create a Pull Request

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

---

**Enjoy building your restaurant management system! 🍽️✨**