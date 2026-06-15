<?php

namespace App\Http\Controllers;

use App\Console\Commands\CheckUploadEnvironment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UploadCheckController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        abort_unless($request->user()?->is_programmer, 404);

        $tmpDir = ini_get('upload_tmp_dir') ?: sys_get_temp_dir();

        return response()->json([
            'note' => 'إعدادات PHP الفعلية لموقع الويب (ليست CLI)',
            'php' => collect(CheckUploadEnvironment::phpUploadRows())
                ->mapWithKeys(fn (array $row) => [$row[0] => $row[1]]),
            'storage' => collect(CheckUploadEnvironment::storageRows())
                ->map(fn (array $row) => [
                    'path' => $row[0],
                    'exists' => $row[1],
                    'writable' => $row[2],
                ]),
            'fixes' => [
                'upload_tmp_dir' => is_writable($tmpDir)
                    ? null
                    : 'عيّن upload_tmp_dir في php.ini / php-fpm إلى مجلد قابل للكتابة (Linux: /tmp)',
                'storage_link' => (is_link(public_path('storage')) || is_dir(public_path('storage')))
                    ? null
                    : 'شغّل: php artisan storage:link',
                'permissions' => 'تأكد أن مستخدم الويب يملك صلاحية الكتابة على storage/ و bootstrap/cache/',
                'upload_limits' => 'upload_max_filesize=20M و post_max_size=25M في php.ini',
            ],
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }
}
