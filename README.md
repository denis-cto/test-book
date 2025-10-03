### 1. Install Composer (if not already installed)

**On macOS:**
```bash
brew install composer
```

**On Ubuntu/Debian:**
```bash
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
```

**On Windows:**
Download and run the installer from https://getcomposer.org/download/

### 2. Install Yii2 and Dependencies

```bash
# Install Composer dependencies
composer install
```

### 3. Start the Application

```bash
# Start Docker containers
docker-compose up -d

# Run database migrations
docker-compose exec php php yii migrate

# Go to http://localhost:8000/
# Admin user login and password: admin/admin
```

## Running Tests

```bash
# Run all tests
docker-compose exec php ./vendor/bin/codecept run

# Run unit tests with verbose output
docker-compose exec php ./vendor/bin/codecept run unit -v

# Run functional tests with verbose output
docker-compose exec php ./vendor/bin/codecept run functional -v
```