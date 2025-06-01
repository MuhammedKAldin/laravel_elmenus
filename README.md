# Elmenus - Multivendor Restaurant SaaS Platform

A comprehensive Laravel-based SaaS platform that enables restaurants to manage their online presence, menus, and orders while providing customers with a seamless discovery and ordering experience, uses Single Database Multivendor architure.

## 🚀 Quick Start

1. Clone the repository
2. Install dependencies:
   ```bash
   composer install
   npm install
   ```
3. Configure environment:
   - Copy `.env.example` to `.env`
   - Set up your database
   - Configure payment gateways
   - Set up storage for restaurant media
4. Run migrations and seed:
   ```bash
   php artisan migrate:fresh --seed
   ```
5. Start development:
   ```bash
   php artisan serve
   npm run dev
   ```

## 💻 Tech Stack

- **Backend**: Laravel
- **Frontend**: 
  - Blade templates
  - TailwindCSS
  - JavaScript
- **Database**: MySQL
- **Payment Processing**: Multiple payment gateways
- **Storage**: Cloud storage for restaurant media
- **Real-time Features**: WebSockets for live order updates

## 🔑 Key Features

### For Restaurant Owners
- Custom restaurant dashboard
- Menu management with categories and items
- Real-time order management
- Analytics and reporting
- Customer feedback management
- Subscription-based access
- Custom domain support
- Bulk menu import/export

### For Customers
- Restaurant discovery and search
- Advanced filtering and sorting
- Real-time order tracking
- Multiple payment methods
- Order history and favorites
- Rating and review system

### For Platform Administrators
- Multi-tenant management
- Subscription management
- Revenue analytics
- Restaurant verification system
- Content moderation
- Platform-wide promotions

## 🏗 Project Structure

```
elmenus/
├── app/                    # Core application code
│   ├── Http/              # Controllers & Middleware
│   │   ├── Controllers/   # Main controllers
│   │   └── Middleware/    # Custom middleware
│   ├── Models/            # Eloquent models
│   ├── Services/          # Business logic
│   │   ├── Restaurant/    # Restaurant-specific services
│   │   ├── Order/        # Order processing services
│   │   └── Payment/      # Payment gateway services
│   ├── Events/           # Event classes
│   ├── Listeners/        # Event listeners
│   └── Providers/        # Service providers
├── resources/             # Frontend resources
│   ├── views/            # Blade templates
│   │   ├── admin/       # Admin panel views
│   │   ├── restaurant/  # Restaurant dashboard views
│   │   └── customer/    # Customer-facing views
│   ├── js/              # JavaScript files
│   └── css/             # Styles
├── routes/               # Application routes
│   ├── web.php          # Web routes
│   ├── api.php          # API routes
│   └── admin.php        # Admin routes
├── database/            # Migrations & seeders
└── public/              # Public assets
```

## 💰 Subscription Tiers

### Basic
- Basic menu management
- Order notifications
- Basic analytics
- Email support

### Professional
- Advanced menu features
- Real-time order tracking
- Detailed analytics
- Priority support
- Custom domain

### Enterprise
- All Professional features
- API access
- White-label solution
- Dedicated support
- Custom integrations

## 🔒 Security Features

- Multi-tenant data isolation
- Role-based access control
- Secure payment processing
- Data encryption
- Regular security audits
- GDPR compliance

## 📄 License

This project is licensed under the [MIT License](LICENSE).
