<?php
if (isset($_GET['file'])) {
    $filename = basename($_GET['file']);

    if (file_exists("certificates/$filename")) {

        header('Content-Type: application/pdf');
        header("Content-Disposition: attachment; filename=$filename");

        readfile("certificates/$filename");
        exit;
    } else {
        echo 'File not found.';
    }
} else {
    echo 'Invalid request.';
}
