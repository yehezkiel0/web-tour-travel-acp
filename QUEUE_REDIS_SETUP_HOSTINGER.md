# Setup Queue dan Redis untuk Hostinger hPanel

## Status Konfigurasi Saat Ini

✅ **Queue System**: Sudah dikonfigurasi dan siap deploy
✅ **Migration**: Sudah berhasil dijalankan
✅ **Database Tables**: jobs, failed_jobs sudah ada
✅ **Job Classes**: SendBookingConfirmationEmail sudah dibuat
✅ **Event/Listener**: BookingCreated dan SendBookingNotification sudah dikonfigurasi

## Konfigurasi `.env` untuk Production

### 1. Queue Configuration

```env
# Queue Configuration
QUEUE_CONNECTION=database  # Gunakan database untuk Hostinger karena Redis tidak tersedia di shared hosting

# Jika menggunakan Redis (hanya jika Hostinger support Redis)
# QUEUE_CONNECTION=redis
# REDIS_HOST=127.0.0.1
# REDIS_PASSWORD=null
# REDIS_PORT=6379
# REDIS_QUEUE=default
```

### 2. Cache Configuration

```env
# Cache Configuration - Gunakan file atau database
CACHE_STORE=file  # atau 'database' jika prefer database caching
```

### 3. Mail Configuration

```env
# Production Mail Settings (Ganti dengan SMTP Hostinger)
MAIL_MAILER=smtp
MAIL_HOST=smtp.hostinger.com
MAIL_PORT=587
MAIL_USERNAME=your-email@yourdomain.com
MAIL_PASSWORD=your-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@yourdomain.com
MAIL_FROM_NAME="${APP_NAME}"
```

### 4. App Configuration

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com
```

## Setup di Hostinger hPanel

### Step 1: Upload Files

1. Upload semua file ke public_html atau subdomain folder
2. Pastikan folder permissions:
   - `storage/` → 755
   - `bootstrap/cache/` → 755

### Step 2: Database Configuration

1. Buat database MySQL di Hostinger
2. Import migrations:
```bash
php artisan migrate --force
```

### Step 3: Queue Worker Setup

#### Opsi A: Cron Job (Recommended untuk Hostinger)

Hostinger shared hosting tidak support long-running processes, jadi gunakan cron job:

1. **Buka hPanel → Advanced → Cron Jobs**

2. **Tambahkan Cron Job berikut:**

```bash
# Jalankan setiap menit untuk process queue
* * * * * cd /home/your-username/public_html && php artisan queue:work --stop-when-empty --max-time=50
```

**Penjelasan:**
- `--stop-when-empty`: Stop setelah semua jobs selesai
- `--max-time=50`: Stop setelah 50 detik (sebelum cron berikutnya)

3. **Alternatif - Schedule Queue:**

```bash
# Jalankan setiap menit untuk process queue dan schedule
* * * * * cd /home/your-username/public_html && php artisan schedule:run >> /dev/null 2>&1
```

Lalu tambahkan di `app/Console/Kernel.php`:

```php
protected function schedule(Schedule $schedule)
{
    // Process queue jobs setiap menit
    $schedule->command('queue:work --stop-when-empty --max-time=50')
        ->everyMinute()
        ->withoutOverlapping();
        
    // Retry failed jobs setiap 5 menit
    $schedule->command('queue:retry all')->everyFiveMinutes();
}
```

#### Opsi B: Manual Process (Development/Testing)

```bash
# Process all queued jobs
php artisan queue:work

# Process jobs with timeout
php artisan queue:work --timeout=60

# Process only 10 jobs then stop
php artisan queue:work --max-jobs=10

# Process jobs on specific queue
php artisan queue:work --queue=notifications,emails,default
```

### Step 4: Monitor Queue

```bash
# Cek failed jobs
php artisan queue:failed

# Retry failed job
php artisan queue:retry <job-id>

# Retry all failed jobs
php artisan queue:retry all

# Clear failed jobs
php artisan queue:flush
```

### Step 5: Clear Cache

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

## File Structure yang Penting

```
app/
├── Events/
│   └── BookingCreated.php          ✅ Sudah dibuat
├── Listeners/
│   └── SendBookingNotification.php  ✅ Sudah dibuat
├── Jobs/
│   └── SendBookingConfirmationEmail.php ✅ Sudah dibuat
├── Mail/
│   └── TicketMail.php              ✅ Sudah dibuat
├── Providers/
│   └── EventServiceProvider.php     ✅ Registered

database/migrations/
├── create_jobs_table.php           ✅ Sudah ada
└── create_failed_jobs_table.php    ✅ Sudah ada
```

## Testing Queue System

### 1. Test Locally

```bash
# Start queue worker
php artisan queue:work

# Di terminal lain, trigger booking creation
php artisan tinker
>>> $booking = \App\Models\BookingTransaction::first();
>>> event(new \App\Events\BookingCreated($booking));
```

### 2. Monitor Logs

```bash
# Tail Laravel logs
tail -f storage/logs/laravel.log

# Check for queue errors
grep "queue" storage/logs/laravel.log
```

## Troubleshooting

### Queue Not Processing

**Solusi:**
```bash
# 1. Restart queue worker
php artisan queue:restart

# 2. Clear old cache
php artisan cache:clear
php artisan config:clear

# 3. Check jobs table
# Pastikan ada data di tabel `jobs`
```

### Email Not Sending

**Cek:**
1. SMTP credentials di `.env` benar
2. Port dan encryption sesuai
3. Email from_address valid
4. Check failed_jobs table

```bash
php artisan queue:failed
```

### Hostinger Specific Issues

**Memory Limit:**
```php
// config/queue.php
'connections' => [
    'database' => [
        'driver' => 'database',
        'queue' => 'default',
        'retry_after' => 90,
        'memory' => 128, // Reduce if needed
    ],
],
```

**Timeout Issues:**
```bash
# Reduce max execution time
php artisan queue:work --timeout=30 --tries=3
```

## Best Practices untuk Production

1. **Error Handling**: Sudah ada try-catch di SendBookingNotification
2. **Job Retry**: Set retry attempts di Job class (sudah set: `$tries = 3`)
3. **Logging**: Gunakan Log facade untuk debugging
4. **Queue Priority**: Gunakan queue names
5. **Job Chaining**: Jika perlu sequence jobs

## Redis Setup (Optional - Jika Hostinger Support)

Jika Hostinger menyediakan Redis:

### 1. Install Redis Extension

```bash
# Via Hostinger PHP Settings
# Enable Redis extension di PHP Configuration
```

### 2. Update `.env`

```env
QUEUE_CONNECTION=redis
REDIS_CLIENT=phpredis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379
```

### 3. Test Redis Connection

```bash
php artisan tinker
>>> \Illuminate\Support\Facades\Redis::connection()->ping()
# Should return: "PONG"
```

## Monitoring Production

### 1. Setup Horizon (Jika pakai Redis)

```bash
composer require laravel/horizon
php artisan horizon:install
```

### 2. Simple Monitoring

Buat file `app/Console/Commands/QueueMonitor.php`:

```php
<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class QueueMonitor extends Command
{
    protected $signature = 'queue:monitor';
    protected $description = 'Monitor queue status';

    public function handle()
    {
        $pending = DB::table('jobs')->count();
        $failed = DB::table('failed_jobs')->count();
        
        $this->info("Pending Jobs: {$pending}");
        $this->info("Failed Jobs: {$failed}");
        
        if ($failed > 0) {
            $this->warn("You have failed jobs. Run: php artisan queue:retry all");
        }
    }
}
```

Jalankan:
```bash
php artisan queue:monitor
```

## Status Checklist

- [x] Queue tables migrated
- [x] Job class created (SendBookingConfirmationEmail)
- [x] Event created (BookingCreated)
- [x] Listener created (SendBookingNotification)
- [x] Mail class configured (TicketMail)
- [x] Error handling implemented
- [x] Retry logic configured
- [ ] Setup cron job di Hostinger
- [ ] Test email sending
- [ ] Monitor in production

## Next Steps

1. ✅ Fix semua undefined variable errors (DONE)
2. ✅ Run migrations (DONE)
3. **Test queue locally**
4. **Deploy ke Hostinger**
5. **Setup cron job di hPanel**
6. **Test email notifications**
7. **Monitor failed jobs**

---

**Note:** Hostinger shared hosting biasanya tidak support Redis dan long-running processes. 
Gunakan **database queue** dengan **cron job** untuk hasil terbaik.
