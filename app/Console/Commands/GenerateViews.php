<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class GenerateViews extends Command
{
    protected $signature = 'generate:views';
    protected $description = 'Generate view structure for BK System';

    public function handle()
    {
        $base = resource_path('views');

        $folders = [
            'layouts',
            'components',
            'admin',
            'user',
            'auth'
        ];

        $files = [
            'layouts/admin.blade.php',
            'layouts/user.blade.php',

            'components/navbar.blade.php',
            'components/sidebar_admin.blade.php',
            'components/sidebar_user.blade.php',

            'admin/dashboard.blade.php',
            'admin/siswa.blade.php',
            'admin/guru.blade.php',
            'admin/kelas.blade.php',
            'admin/mata_pelajaran.blade.php',
            'admin/pelanggaran.blade.php',
            'admin/prediksi.blade.php',

            'user/dashboard.blade.php',
            'user/profil.blade.php',
            'user/hasil_prediksi.blade.php',

            'auth/login.blade.php'
        ];

        foreach ($folders as $folder) {
            File::ensureDirectoryExists($base.'/'.$folder);
        }

        foreach ($files as $file) {
            $path = $base.'/'.$file;

            if (!File::exists($path)) {
                File::put($path,"{{-- ".$file." --}}");
            }
        }

        $this->info('Struktur views berhasil dibuat!');
    }
}
