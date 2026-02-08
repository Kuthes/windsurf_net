# Sentinel ISP Hotspot Controller

An enterprise-level ISP Hotspot Controller built with Docker Compose, Laravel 11, MySQL 8.0, FreeRADIUS 3.0, and Nginx.

## Architecture

- **Database**: MySQL 8.0 container shared by Laravel and FreeRADIUS
- **RADIUS**: FreeRADIUS 3.0 container configured with SQL module
- **Application**: Laravel 11 app for user management and analytics
- **Web Server**: Nginx container serving the Laravel application
- **Network**: All containers on `hotspot_net` bridge network

## Features

- User management through Laravel web interface
- RADIUS authentication with MySQL backend
- Session accounting and analytics
- Real-time active sessions monitoring
- Bandwidth usage tracking
- User group management

## Quick Start

### Prerequisites

- Docker and Docker Compose
- Git

### Installation

1. Clone the repository:
```bash
git clone <repository-url>
cd sentinel-hotspot-controller
```

2. Copy Laravel environment file:
```bash
cp laravel/.env.example laravel/.env
```

3. Start all services:
```bash
docker-compose up -d
```

4. Install Laravel dependencies and generate app key:
```bash
docker-compose exec app composer install
docker-compose exec app php artisan key:generate
```

5. Initialize Laravel storage:
```bash
docker-compose exec app php artisan storage:link
docker-compose exec app chmod -R 777 storage bootstrap/cache
```

### Access the Application

- **Web Interface**: http://localhost
- **Test User**: `testuser` / `test123`

## Configuration

### Database

The MySQL database is automatically initialized with the RADIUS schema on first startup. Default credentials:

- **Database**: `radius`
- **Username**: `radius_user`
- **Password**: `radius_password`
- **Root Password**: `root_password`

### FreeRADIUS

FreeRADIUS is configured to use the SQL module for authentication and accounting. Key configuration files:

- `freeradius/config/radiusd.conf` - Main configuration
- `freeradius/config/clients.conf` - Client (NAS) definitions
- `freeradius/mods-available/sql` - SQL module configuration
- `freeradius/sites-available/default` - Virtual server configuration

### Laravel

The Laravel application is configured to connect to the shared MySQL database. Environment variables are set in `docker-compose.yml` and can be overridden in `laravel/.env`.

## Usage

### User Management

1. **Create Users**: Navigate to Users → Create New User
2. **Manage Users**: View, edit passwords, or delete users from the Users page
3. **Monitor Sessions**: View active sessions on the Dashboard

### RADIUS Authentication

The system supports standard RADIUS authentication:

- **Auth Port**: 1812/UDP
- **Acct Port**: 1813/UDP
- **Secret**: `testing123`

### API Integration

The Laravel models can be used to integrate with external systems:

```php
// Create a new user
use App\Models\RadUser;
RadUser::createUser('newuser', 'password123', 'hotspot_users');

// Get active sessions
use App\Models\RadAcct;
$sessions = RadAcct::getActiveSessions();

// Get usage statistics
$stats = RadAcct::getSessionStats(30);
```

## Database Schema

### radcheck table
Stores user authentication attributes:
- `username` - User identifier
- `attribute` - RADIUS attribute (e.g., Cleartext-Password)
- `op` - Operator (e.g., :=)
- `value` - Attribute value

### radacct table
Stores accounting information:
- Session details (start/stop times, duration)
- Bandwidth usage (upload/download bytes)
- Network information (IP addresses, NAS details)

### radusergroup table
Maps users to groups for attribute inheritance.

## Development

### Adding New Features

1. **Controllers**: Add new controllers in `laravel/app/Http/Controllers/`
2. **Models**: Extend existing models or create new ones in `laravel/app/Models/`
3. **Views**: Add Blade templates in `laravel/resources/views/`
4. **Routes**: Define routes in `laravel/routes/web.php`

### Testing

Run Laravel tests:
```bash
docker-compose exec app php artisan test
```

### Logs

- **Laravel Logs**: `docker-compose exec app tail -f storage/logs/laravel.log`
- **Nginx Logs**: `docker-compose logs nginx`
- **FreeRADIUS Logs**: `docker-compose logs freeradius`
- **MySQL Logs**: `docker-compose logs mysql`

## Security Considerations

- Change default passwords in production
- Use HTTPS in production (configure SSL certificates)
- Restrict RADIUS client access in `clients.conf`
- Implement proper firewall rules
- Regular database backups

## Troubleshooting

### Common Issues

1. **Laravel 500 Error**: Check file permissions and ensure `.env` is configured
2. **RADIUS Authentication Failed**: Verify FreeRADIUS logs and SQL connectivity
3. **Database Connection**: Ensure MySQL container is running and accessible

### Debug Commands

```bash
# Check container status
docker-compose ps

# View FreeRADIUS logs
docker-compose logs freeradius

# Test RADIUS authentication
docker-compose exec freeradius radtest testuser test123 localhost 1812 testing123

# Access MySQL
docker-compose exec mysql mysql -u radius_user -p radius
```

## License

MIT License - see LICENSE file for details.

## Support

For issues and support, please create an issue in the repository.
