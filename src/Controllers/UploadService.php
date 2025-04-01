<?php

namespace App\Controllers;

use finfo;
class UploadService {
    private const MAX_FILE_SIZE = 10485760;
    private const UPLOAD_DIR = 'uploads/';
    private const ALLOWED_TYPES = [
        'application/pdf',
    ];

    private string $fileName = '';

    public function handleUpload(array $file): bool {
        if (!$this->validateFilePresence($file)) {
            return false;
        }

        if (!$this->validateFileSize($file['size'])) {
            return false;
        }

        if (!$this->validateFileType($file['tmp_name'])) {
            return false;
        }

        if (!$this->moveFile($file['tmp_name'], $file['name'])) {
            return false;
        }

        return true;
    }

    public function validateFilePresence(array $file): bool {
        if (!isset($file) || $file['error'] !== UPLOAD_ERR_OK) {
            return false;
        }
        return true;
    }

    public function validateFileSize(int $size): bool {
        if ($size > self::MAX_FILE_SIZE) {
            return false;
        }
        return true;
    }

    public function validateFileType(string $tmpName): bool {
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->file($tmpName);

        if (!in_array($mimeType, self::ALLOWED_TYPES)) {
            return false;
        }
        return true;
    }

    public function moveFile(string $tmpName, string $originalName): bool {
        $this->fileName = htmlspecialchars($originalName, ENT_QUOTES, 'UTF-8');
        $destination = self::UPLOAD_DIR . $this->fileName;

        if (!move_uploaded_file($tmpName, $destination)) {
            return false;
        }
        return true;
    }

    public function pathFile(array $file) {
        return self::UPLOAD_DIR . $file['name'];
    }
}
