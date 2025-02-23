<?php

namespace App\Console\Commands;

function ftp_connect($server) {
    return true; // Immer eine "erfolgreiche" Verbindung simulieren
}

function ftp_login($conn, $username, $password) {
    return true;
}

function ftp_put($conn, $remoteFile, $localFile, $mode) {
    return true; // Erfolgreiches Hochladen simulieren
}

function ftp_delete($conn, $remoteFile) {
    return true; // Erfolgreiches Löschen simulieren
}

function ftp_close($conn) {
    return true;
}

function ftp_pasv($conn, $mode) {
    return true; // Erfolgreichen Passive Mode simulieren
}
