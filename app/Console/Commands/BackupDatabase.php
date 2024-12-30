<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BackupDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backup:database';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backup the database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $dbName = env('DB_DATABASE');
        $dbUser = env('DB_USERNAME');
        $dbPass = env('DB_PASSWORD');
        $dbHost = env('DB_HOST');
        $backupPath = storage_path('app/backup');
        $backupFile = $backupPath . '/backup_' . now()->format('Y_m_d_H_i_s') . '.sql';

        if (!file_exists($backupPath)) {
            mkdir($backupPath, 0755, true);
        }

        $command = "mysqldump --user={$dbUser} --password={$dbPass} --host={$dbHost} {$dbName} > {$backupFile}";

        $returnVar = null;
        $output = null;
        exec($command, $output, $returnVar);

        if ($returnVar !== 0) {
            $this->error('Failed to backup the database');
            return 1;
        }

        $this->info('Database backup successfully saved to ' . $backupFile);
        return 0;
    }
}
