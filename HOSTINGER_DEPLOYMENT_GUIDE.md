# 🚀 **Panduan Lengkap Deploy ke Hostinger HPanel**

Saya akan memberikan panduan lengkap untuk setup Redis, Queue, dan Migration di Hostinger HPanel:

## 📋 **Table of Contents**

1. [Setup Redis di Hostinger](#1-setup-redis-di-hostinger)
2. [Setup Queue Workers](#2-setup-queue-workers)
3. [Environment Configuration](#3-environment-configuration)
4. [Migration Script](#4-migration-script)
5. [Auto Deploy Setup](#5-auto-deploy-setup)
6. [Troubleshooting](#6-troubleshooting)
7. [Performance Monitoring](#7-performance-monitoring)

---

## 1. 🔴 **Setup Redis di Hostinger**

### **A. Install Redis via HPanel**

1. Login ke **hpanel.hostinger.com**
2. Pilih domain → **Advanced** → **Redis Manager**
3. Jika Redis tidak tersedia:
    - Klik **Advanced** → **PHP Extensions**
    - Cari **Redis** dan install

### **B. Manual Redis Setup (Jika tidak ada di HPanel)**

```bash
# SSH ke server Hostinger
ssh user@your-server.com

# Install Redis
sudo apt-get update
sudo apt-get install redis-server

# Konfigurasi Redis
sudo nano /etc/redis/redis.conf
```

**Konfigurasi Redis yang direkomendasikan:**

```bash
# /etc/redis/redis.conf
daemonize yes
port 6379
bind 127.0.0.1
timeout 0
save 900 1
maxmemory 256mb
maxmemory-policy allkeys-lru
requirepass your-secure-password
```

### **C. Start Redis Server**

```bash
# Start Redis
sudo systemctl start redis-server
sudo systemctl enable redis-server

# Verifikasi Redis running
sudo systemctl status redis-server
redis-cli ping
```

### **D. Test Redis Connection**

```bash
# Test dari Laravel
php artisan tinker
>>> Redis::set('test_key', 'test_value', 60)
>>> Redis::get('test_key')
# Harus return 'test_value'
```

---

## 2. 🟡 **Setup Queue Workers**

### **A. Buat Queue Worker Script**

**File: `start-queue-workers.sh`**

```bash
#!/bin/bash

# Queue Worker Configuration
WORKERS=3
QUEUE_CONNECTION=redis
MEMORY_LIMIT=128M
MAX_EXECUTION_TIME=300

echo "🚀 Starting $WORKERS queue workers..."

# Kill existing workers
pkill -f "php artisan queue:work"

# Start new workers
for i in $(seq 1 $WORKERS); do
    nohup php artisan queue:work \
        --queue=default \
        --sleep=1 \
        --tries=3 \
        --max-time=3600 \
        --memory=$MEMORY_LIMIT \
        > storage/logs/worker-$i.log 2>&1 &

    echo "Worker $i started with PID: $!"
done

echo "✅ All queue workers started"
echo "Active workers: $(ps aux | grep 'php artisan queue:work' | wc -l)"
```

### **B. Setup Cron Job untuk Queue Workers**

1. **HPanel** → **Advanced** → **Cron Jobs**
2. Tambah cron job baru:

**Cron Job Configuration:**

```
Type: Standard
Command: /bin/bash /home/u123456789/public_html/start-queue-workers.sh
Run: Every 5 Minutes
```

### **C. Alternative: Supervisor Setup**

```bash
# Install supervisor
sudo apt-get install supervisor

# Buat supervisor config
sudo nano /etc/supervisor/conf.d/laravel-workers.conf
```

**Supervisor Config:**

```ini
[program:laravel-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /home/u123456789/public_html/artisan queue:work --sleep=1 --tries=3 --max-time=3600
autostart=true
autorestart=true
user=www-data
numprocs=3
redirect_stderr=true
stdout_logfile=/home/u123456789/public_html/storage/logs/worker.log
```

---

## 3. 📝 **Environment Configuration**

### **A. Production .env untuk Hostinger**

```bash
# Copy dan edit file .env
APP_NAME=ACP
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com

# Database Configuration
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=your_hostinger_db
DB_USERNAME=your_hostinger_user
DB_PASSWORD=your_hostinger_password

# Redis Configuration
CACHE_DRIVER=redis
CACHE_STORE=redis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=your_redis_password
REDIS_PORT=6379

# Queue Configuration
QUEUE_CONNECTION=redis
QUEUE_FAILED_DRIVER=database-uuids

# Session Configuration
SESSION_DRIVER=redis
SESSION_LIFETIME=120

# Performance Configuration
MEMORY_LIMIT=128M
MAX_EXECUTION_TIME=300

# File Upload
FILESYSTEM_DISK=local

# Logging
LOG_CHANNEL=stack
LOG_LEVEL=warning
```

### **B. Database Configuration untuk Hostinger**

```php
// config/database.php
'connections' => [
    'mysql' => [
        'driver' => 'mysql',
        'host' => env('DB_HOST', '127.0.0.1'),
        'port' => env('DB_PORT', '3306'),
        'database' => env('DB_DATABASE', 'forge'),
        'username' => env('DB_USERNAME', 'forge'),
        'password' => env('DB_PASSWORD', ''),
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
        'prefix' => '',
        'strict' => true,
        'engine' => null,
        'options' => extension=pdo_mysql,
        'modes' => [
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET sql_mode=STRICT_TRANS_TABLES',
        ],
    ],
],
```

---

## 4. 🔄 **Migration Script**

### **A. Safe Migration Script**

**File: `safe-migrate.sh`**

```bash
#!/bin/bash

echo "🚀 Starting safe migration process..."

# Environment setup
export APP_ENV=production
export APP_DEBUG=false

# Pre-migration checks
echo "Running pre-migration checks..."

# Check database connection
echo "Testing database connection..."
php artisan tinker --execute="
try {
    DB::connection()->getPdo();
    echo 'Database connection: OK';
    exit(0);
} catch (Exception \$e) {
    echo 'Database connection failed: ' . \$e->getMessage();
    exit(1);
}
" || exit 1

if [ $? -ne 0 ]; then
    echo "❌ Database connection failed"
    echo "Please check your .env database credentials"
    exit 1
fi

# Clear caches
echo "Clearing all caches..."
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Check migration status
echo "Checking current migration status..."
php artisan migrate:status

# Backup sebelum migration (opsional)
echo "Creating backup..."
php artisan db:show --database=your_database > backup_$(date +%Y%m%d_%H%M%S).sql

# Run migration dengan error handling
echo "Running migrations..."
php artisan migrate --force --step 2>&1 | tee migration.log

# Check migration result
if [ $? -eq 0 ]; then
    echo "✅ Migration completed successfully"

    # Optimize setelah migration
    echo "Optimizing application..."
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache

    echo "🎉 Migration and optimization completed!"
else
    echo "❌ Migration failed"
    echo "Checking migration log..."

    # Show error details
    echo "Last 20 lines of migration log:"
    tail -20 migration.log

    # Try to continue with next batch
    echo "Attempting to continue with next batch..."
    php artisan migrate --force --batch

    if [ $? -eq 0 ]; then
        echo "✅ Continued migration successful"
    else
        echo "❌ Continued migration failed"
        echo "Manual intervention required"
    fi
fi

# Set proper permissions
echo "Setting proper permissions..."
chmod -R 755 storage
chmod -R 755 bootstrap/cache

echo "✅ Safe migration process completed!"
```

### **B. Migration Commands untuk Debugging**

```bash
# Check migration status
php artisan migrate:status

# Run specific migration
php artisan migrate --path=database/migrations/2025_11_12_032800_add_indexes_to_performance_tables.php

# Run migration dengan pretend
php artisan migrate --pretend

# Rollback last migration
php artisan migrate:rollback --step=1

# Fresh migrate (HATI-HATI)
php artisan migrate:fresh --seed --force
```

---

## 5. 🚀 **Auto Deploy Setup**

### **A. GitHub Webhook Configuration**

1. **HPanel** → **Advanced** → **Git & GitHub**
2. **Setup Auto Deploy**:
    - Repository: `web-tour-travel-acp`
    - Branch: `main`
    - Deployment Path: `public_html/`
    - Deployment Commands:
        ```bash
        composer install --no-dev --optimize-autoloader
        php artisan cache:clear
        php artisan migrate --force
        php artisan config:cache
        php artisan route:cache
        php artisan view:cache
        ```

### **B. Deploy Script untuk Hostinger**

**File: `deploy-to-hostinger.sh`**

```bash
#!/bin/bash

echo "🚀 Starting deployment to Hostinger..."

# Set environment
export APP_ENV=production
export APP_DEBUG=false

# Navigate to project directory
cd /home/u123456789/public_html

# Pull latest changes
echo "Pulling latest changes from GitHub..."
git pull origin main

# Handle pull conflicts
if [ $? -ne 0 ]; then
    echo "❌ Git pull failed"
    echo "Resolving conflicts..."
    git stash
    git pull origin main
    git stash pop
fi

# Install dependencies
echo "Installing dependencies..."
composer install --no-dev --optimize-autoloader --no-interaction

# Clear all caches
echo "Clearing caches..."
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Set permissions
echo "Setting permissions..."
chmod -R 755 storage
chmod -R 755 bootstrap/cache

# Run safe migration
echo "Running safe migration..."
./safe-migrate.sh

if [ $? -eq 0 ]; then
    echo "✅ Migration successful"
else
    echo "❌ Migration failed"
    echo "Deployment stopped due to migration failure"
    exit 1
fi

# Optimize for production
echo "Optimizing for production..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Restart queue workers
echo "Restarting queue workers..."
pkill -f "php artisan queue:work"
./start-queue-workers.sh

# Final optimization
echo "Final optimizations..."
php artisan optimize

echo "🎉 Deployment completed successfully!"
echo "Deployment time: $(date)"
```

### **C. Setup Auto Deploy Cron**

```bash
# Di HPanel → Advanced → Cron Jobs
Command: /bin/bash /home/u123456789/public_html/deploy-to-hostinger.sh
Run: Every 10 Minutes
```

---

## 6. 🛠️ **Troubleshooting**

### **A. Common Error Solutions**

#### **Error: "SQLSTATE[HY000] General error: 1 Can't create/write to file"**

```bash
# Solution: Fix permissions
chmod -R 755 storage
chmod -R 755 storage/framework
chmod -R 755 bootstrap/cache
```

#### **Error: "Connection refused"**

```bash
# Check MySQL service
sudo service mysql status
sudo service mysql restart

# Check Redis service
sudo service redis-server status
sudo service redis-server restart
```

#### **Error: "Maximum execution time exceeded"**

```bash
# Increase PHP limits
# Di HPanel → Select PHP Version → Edit php.ini
max_execution_time = 300
memory_limit = 256M
post_max_size = 64M
```

#### **Error: "Redis connection failed"**

```bash
# Test Redis connection
redis-cli ping

# Check Redis config
redis-cli config get "*"

# Restart Redis
sudo service redis-server restart
```

### **B. Debug Commands**

```bash
# Check all services status
echo "=== Service Status ==="
echo "MySQL: $(sudo service mysql status)"
echo "Redis: $(sudo service redis-server status)"
echo "Queue Workers: $(ps aux | grep 'php artisan queue:work' | wc -l)"

# Check Laravel environment
php artisan env
php artisan tinker --execute="echo 'Environment: ' . app()->environment();"

# Check cache status
php artisan cache:clear --show
```

---

## 7. 📊 **Performance Monitoring**

### **A. Monitoring Route**

```php
// routes/web.php
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/system-status', function () {
        return response()->json([
            'timestamp' => now(),
            'memory_usage' => memory_get_usage(true),
            'redis_status' => Redis::ping() ? 'connected' : 'disconnected',
            'queue_workers' => shell_exec('ps aux | grep "php artisan queue:work" | wc -l'),
            'database_connection' => DB::connection()->getPdo() ? 'connected' : 'failed',
            'last_migration' => DB::table('migrations')->latest('id')->first(),
            'cache_status' => Cache::get('system_status', 'unknown'),
        ]);
    });
});
```

### **B. Performance Test Script**

**File: `performance-test.sh`**

```bash
#!/bin/bash

echo "🔍 Running performance tests..."

# Test database query performance
echo "Testing database queries..."
php artisan tinker --execute="
\$start = microtime(true);
DB::table('users')->count();
\$duration = microtime(true) - \$start;
echo 'Query time: ' . (\$duration * 1000) . 'ms';
"

# Test cache performance
echo "Testing cache performance..."
php artisan tinker --execute="
\$start = microtime(true);
Cache::set('test_key', 'test_value', 60);
\$value = Cache::get('test_key');
\$duration = microtime(true) - \$start;
echo 'Cache time: ' . (\$duration * 1000) . 'ms';
"

# Test queue performance
echo "Testing queue performance..."
php artisan tinker --execute="
\$start = microtime(true);
dispatch(new \App\Jobs\SendBookingConfirmationEmail(\$booking));
\$duration = microtime(true) - \$start;
echo 'Queue dispatch time: ' . (\$duration * 1000) . 'ms';
"

echo "✅ Performance tests completed"
```

---

## 🎯 **Deployment Checklist**

### **Pre-Deployment Checklist**

-   [ ] Redis server installed and running
-   [ ] Database credentials tested
-   [ ] Environment variables set
-   [ ] File permissions correct
-   [ ] Migration script ready
-   [ ] Queue worker script ready
-   [ ] Deploy script tested

### **Post-Deployment Checklist**

-   [ ] Git pull successful
-   [ ] Dependencies installed
-   [ ] Caches cleared
-   [ ] Migration completed
-   [ ] Queue workers started
-   [ ] Redis connection verified
-   [ ] Application optimized
-   [ ] All services running

### **Monitoring Checklist**

-   [ ] Response time < 2 seconds
-   [ ] Memory usage < 128MB
-   [ ] Cache hit ratio > 80%
-   [ ] Queue processing < 5 seconds
-   [ ] Error rate < 1%
-   [ ] Uptime > 99%

---

## 📞 **Emergency Procedures**

### **If Migration Fails**

```bash
# 1. Rollback migration
php artisan migrate:rollback --step=1

# 2. Restore from backup
mysql your_database < backup_20251112_120000.sql

# 3. Contact support
echo "Migration failed. Please contact support with error details."
```

### **If Queue Workers Fail**

```bash
# 1. Restart workers
pkill -f "php artisan queue:work"
./start-queue-workers.sh

# 2. Check queue table
php artisan queue:failed

# 3. Clear stuck jobs
php artisan queue:clear
```

---

## 🎉 **Success Metrics**

Dengan setup ini, Anda seharusnya mendapatkan:

-   **Response Time**: 500ms - 1.5 detik
-   **Memory Usage**: 64-128MB
-   **Cache Hit Ratio**: 85-95%
-   **Queue Processing**: 100-500 jobs/hour
-   **Database Queries**: 10-25 per request
-   **Uptime**: 99.5%
-   **Error Rate**: < 0.1%

## 📞 **Support Information**

Jika mengalami masalah:

1. **Hostinger Support**: Login ke HPanel → Support → Live Chat
2. **Documentation**: Lihat `HOSTINGER_DEPLOYMENT_GUIDE.md`
3. **Error Logs**: Check `storage/logs/laravel.log`
4. **System Status**: Akses `/admin/system-status`

Dengan mengikuti panduan ini, aplikasi Laravel Anda akan berjalan optimal di Hostinger dengan Redis cache dan queue system yang handal.
