<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class CheckUploadEnvironment extends Command
{
    protected $signature = 'app:check-uploads';

    protected $description = 'Diagnose PHP upload and storage settings for file uploads';

    public function handle(): int
    {
        $this->warn('هذا الفحص يستخدم PHP من سطر الأوامر (CLI). إعدادات موقع الويب قد تختلف — استخدم /dev/upload-check من المتصفح بعد تسجيل الدخول كمطوّر.');

        $this->newLine();
        $this->line('── إعدادات PHP ──');
        $this->table(
            ['الإعداد', 'القيمة'],
            $this->phpUploadRows(),
        );

        $this->newLine();
        $this->line('── مجلدات التخزين ──');
        $this->table(
            ['المسار', 'موجود', 'قابل للكتابة'],
            $this->storageRows(),
        );

        $tmpDir = ini_get('upload_tmp_dir') ?: sys_get_temp_dir();

        if (! is_writable($tmpDir)) {
            $this->error("مجلد الرفع المؤقت غير قابل للكتابة: {$tmpDir}");
            $this->line('الحل: عدّل upload_tmp_dir في php.ini لمجلد قابل للكتابة (مثل /tmp على Linux).');
        }

        if ((int) ini_get('upload_max_filesize') < 10) {
            $this->warn('upload_max_filesize صغير — يُفضّل 20M على الأقل لصور الهاتف.');
        }

        if (! is_link(public_path('storage')) && ! is_dir(public_path('storage'))) {
            $this->warn('رابط storage غير موجود — شغّل: php artisan storage:link');
        }

        return self::SUCCESS;
    }

    /**
     * @return array<int, array{0: string, 1: string}>
     */
    public static function phpUploadRows(): array
    {
        $tmpDir = ini_get('upload_tmp_dir') ?: sys_get_temp_dir();

        return [
            ['php.ini', php_ini_loaded_file() ?: '—'],
            ['upload_tmp_dir', ini_get('upload_tmp_dir') ?: "(افتراضي: {$tmpDir})"],
            ['upload_tmp_dir قابل للكتابة', is_writable($tmpDir) ? 'نعم' : 'لا'],
            ['file_uploads', ini_get('file_uploads') ? 'On' : 'Off'],
            ['upload_max_filesize', ini_get('upload_max_filesize')],
            ['post_max_size', ini_get('post_max_size')],
            ['memory_limit', ini_get('memory_limit')],
        ];
    }

    /**
     * @return array<int, array{0: string, 1: string, 2: string}>
     */
    public static function storageRows(): array
    {
        $paths = [
            storage_path('app/private/livewire-tmp'),
            storage_path('app/public'),
            storage_path('app/public/garden/plants/cards'),
            storage_path('app/public/garden/events'),
            storage_path('framework/cache'),
            storage_path('logs'),
            public_path('storage'),
        ];

        return collect($paths)->map(fn (string $path): array => [
            $path,
            (File::isDirectory($path) || is_link($path)) ? 'نعم' : 'لا',
            (File::isDirectory($path) || is_link($path)) && is_writable($path) ? 'نعم' : 'لا',
        ])->all();
    }
}
