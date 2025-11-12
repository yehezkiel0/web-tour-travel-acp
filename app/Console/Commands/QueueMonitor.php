<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class QueueMonitor extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'queue:monitor';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Monitor queue status and show pending/failed jobs';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔍 Queue Monitor Dashboard');
        $this->newLine();

        // Check pending jobs
        $pending = DB::table('jobs')->count();
        $this->line("📋 Pending Jobs: <fg=yellow>{$pending}</>");

        if ($pending > 0) {
            $this->warn("   Run: php artisan queue:work");
            $this->newLine();

            // Show sample of pending jobs
            $jobs = DB::table('jobs')
                ->orderBy('id', 'desc')
                ->limit(5)
                ->get();

            if ($jobs->isNotEmpty()) {
                $this->table(
                    ['ID', 'Queue', 'Attempts', 'Created'],
                    $jobs->map(function ($job) {
                        return [
                            $job->id,
                            $job->queue,
                            $job->attempts,
                            date('Y-m-d H:i:s', $job->created_at),
                        ];
                    })
                );
            }
        } else {
            $this->info("   ✅ All jobs processed!");
        }

        $this->newLine();

        // Check failed jobs
        $failed = DB::table('failed_jobs')->count();
        if ($failed > 0) {
            $this->line("❌ Failed Jobs: <fg=red>{$failed}</>");
            $this->error("   Run: php artisan queue:retry all");
            $this->newLine();

            // Show sample of failed jobs
            $failedJobs = DB::table('failed_jobs')
                ->orderBy('id', 'desc')
                ->limit(5)
                ->get();

            if ($failedJobs->isNotEmpty()) {
                $this->table(
                    ['ID', 'Queue', 'Failed At'],
                    $failedJobs->map(function ($job) {
                        return [
                            $job->id,
                            $job->queue ?? 'default',
                            $job->failed_at,
                        ];
                    })
                );

                $this->newLine();
                $this->comment('To see error details: php artisan queue:failed');
            }
        } else {
            $this->line("✅ Failed Jobs: <fg=green>{$failed}</>");
            $this->info("   No failed jobs!");
        }

        $this->newLine();

        // Show queue connection
        $connection = config('queue.default');
        $this->line("🔌 Queue Connection: <fg=cyan>{$connection}</>");

        // Show cache driver
        $cache = config('cache.default');
        $this->line("💾 Cache Driver: <fg=cyan>{$cache}</>");

        $this->newLine();
        $this->info('Dashboard complete! 🎉');

        return Command::SUCCESS;
    }
}
