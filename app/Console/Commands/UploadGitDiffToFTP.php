<?php

namespace App\Console\Commands;

use FTP\Connection;
use Illuminate\Console\Command;

class UploadGitDiffToFTP extends Command
{
    protected $signature = 'ftp:upload-git-diff';

    protected $description = 'Ermittelt geänderte Dateien aus Git und lädt sie via FTP hoch oder löscht entfernte Dateien';

    private false|Connection $connId;

    private string $remoteDir;

    public function handle(): void
    {
        $fileChanges = $this->getGitDiff();

        $this->remoteDir = config('ftp.remote_dir');

        if (!$this->connectToFtp()) {
            return;
        }

        foreach ($fileChanges as $data) {
            $this->processFileAction($data);
        }

        ftp_close($this->connId);
        $this->info('FTP-Upload abgeschlossen.');
    }

    protected function getGitDiff(): array
    {
        $command = 'git diff --name-status origin/main...origin/dev';
        $output = shell_exec($command);

        if ($output === null) {
            $this->error('Fehler beim Abrufen der Git-Differenzen.');

            return [];
        }

        $lines = explode("\n", trim($output));
        $fileChanges = [];

        foreach ($lines as $line) {
            $fields = preg_split('/\s+/', $line, 3);
            if (isset($fields[0], $fields[1])) {
                $fileChanges[] = [
                    'status' => $fields[0],
                    'old_name' => $fields[1],
                    'new_name' => $fields[2] ?? '',
                ];
            }
        }

        return $fileChanges;
    }

    protected function connectToFtp(): bool
    {
        $server = config('ftp.server');
        $username = config('ftp.username');
        $password = config('ftp.password');
        $port = config('ftp.port');
        $timeout = config('ftp.timeout');

        $this->connId = ftp_connect($server, $port, $timeout);
        if (!$this->connId) {
            $this->error('Konnte keine Verbindung zum FTP-Server herstellen.');

            return false;
        }

        if (!ftp_login($this->connId, $username, $password)) {
            ftp_close($this->connId);
            $this->error('FTP-Login fehlgeschlagen.');

            return false;
        }

        $passiveMode = config('ftp.passive');
        ftp_pasv($this->connId, $passiveMode);

        return true;
    }

    protected function processFileAction(array $data): void
    {
        $status = $data['status'];
        $localFile = $data['old_name'];
        $newFileName = $data['new_name'];

        $localFilePath = base_path($localFile);
        $remoteFilePath = $this->remoteDir.($newFileName ?: $localFile);

        if ($status === 'R') {
            $this->deleteFile($this->remoteDir.$localFile);
            $this->uploadFile($localFilePath, $remoteFilePath);
        } elseif (in_array($status, ['A', 'M'], true)) {
            $this->uploadFile($localFilePath, $remoteFilePath);
        } elseif ($status === 'D') {
            $this->deleteFile($remoteFilePath);
        }
    }

    protected function uploadFile(string $localFilePath, string $remoteFilePath): void
    {
        if (file_exists($localFilePath)) {
            $this->info("Hochladen: $localFilePath -> $remoteFilePath");
            if (!ftp_put($this->connId, $remoteFilePath, $localFilePath, FTP_BINARY)) {
                $this->error("Fehler beim Hochladen von $localFilePath");
            }
        } else {
            $this->error("Lokale Datei nicht gefunden: $localFilePath");
        }
    }

    protected function deleteFile(string $remoteFilePath): void
    {
        $this->info("Löschen: $remoteFilePath");
        if (!ftp_delete($this->connId, $remoteFilePath)) {
            $this->error("Fehler beim Löschen von $remoteFilePath");
        }
    }
}
