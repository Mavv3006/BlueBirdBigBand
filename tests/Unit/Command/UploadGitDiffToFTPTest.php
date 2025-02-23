<?php

namespace Tests\Unit\Command;

use App\Console\Commands\UploadGitDiffToFTP;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;

class UploadGitDiffToFTPTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // FTP-Konfiguration mocken
        Config::set('ftp.server', 'ftp.example.com');
        Config::set('ftp.username', 'testuser');
        Config::set('ftp.password', 'testpassword');
        Config::set('ftp.remote_dir', '/remote/path');
        Config::set('ftp.passive', true);
    }

    public function test_command_executes_successfully(): void
    {
        // Laravel Service-Container mit Mock überschreiben
        $mock = $this->partialMock(UploadGitDiffToFTP::class, function ($mock) {
            $mock->shouldAllowMockingProtectedMethods()
                ->shouldReceive('getGitDiff')
                ->andReturn([
                    ['status' => 'A', 'old_name' => 'file1.txt', 'new_name' => ''],
                    ['status' => 'M', 'old_name' => 'file2.txt', 'new_name' => ''],
                    ['status' => 'D', 'old_name' => 'file3.txt', 'new_name' => ''],
                    ['status' => 'R', 'old_name' => 'old_name.txt', 'new_name' => 'new_name.txt'],
                ]);
        });

        // Command ausführen
        Artisan::call('ftp:upload-git-diff');

        // Prüfung der Ausgabe
        $output = Artisan::output();
        $this->assertStringContainsString('FTP-Upload abgeschlossen', $output);
    }
}
