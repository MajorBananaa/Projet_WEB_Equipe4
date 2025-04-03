<?php

namespace App\Controllers;

use finfo;

class UploadService
{

    private $file;
    private $fileName;
    private $maxFileSize;
    private $allowedTypes;
    private $uploadDir;

    /**
     * UploadService constructor.
     *
     * @param array $file Le fichier téléchargé via $_FILES.
     * @param int $maxFileSize La taille maximale du fichier en octets.
     * @param array $allowedTypes Types MIME autorisés pour le fichier.
     * @param string $uploadDir Le répertoire de stockage du fichier.
     */
    public function __construct(array $file, int $maxFileSize, array $allowedTypes, string $uploadDir)
    {
        $this->file = $file;
        $this->maxFileSize = $maxFileSize;
        $this->allowedTypes = $allowedTypes;
        $this->uploadDir = rtrim($uploadDir, '/') . '/';
    }

    /**
     * Valide la présence et l'absence d'erreurs du fichier.
     *
     * @return bool Retourne true si le fichier est valide, sinon false.
     */
    public function validateFilePresence(): bool
    {
        if (!isset($this->file) || $this->file['error'] !== UPLOAD_ERR_OK) {
            return false;
        }
        return true;
    }

    /**
     * Valide si la taille du fichier ne dépasse pas la taille maximale autorisée.
     *
     * @return bool Retourne true si la taille du fichier est valide, sinon false.
     */
    public function validateFileSize(): bool
    {
        if ($this->file['size'] > $this->maxFileSize) {
            return false;
        }
        return true;
    }

    /**
     * Valide le type MIME du fichier.
     *
     * @return bool Retourne true si le type MIME est autorisé, sinon false.
     */
    public function validateFileType(): bool
    {
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->file($this->file['tmp_name']);

        if (!in_array($mimeType, $this->allowedTypes)) {
            return false;
        }
        return true;
    }

    /**
     * Déplace le fichier téléchargé dans le répertoire de destination.
     *
     * @return bool Retourne true si le fichier a été déplacé avec succès, sinon false.
     */
    public function moveFile(): bool
    {
        $this->fileName = htmlspecialchars($this->file['name'], ENT_QUOTES, 'UTF-8');
        $destination = $this->uploadDir . $this->fileName;

        if (!move_uploaded_file($this->file['tmp_name'], $destination)) {
            return false;
        }
        return true;
    }

    /**
     * Retourne le chemin complet du fichier téléchargé.
     *
     * @return string Le chemin complet du fichier dans le répertoire de stockage.
     */
    public function pathFile(): string
    {
        return $this->uploadDir . $this->file['name'];
    }

    /**
     * Exécute toutes les méthodes de validation et de déplacement du fichier.
     *
     * @return string|false Retourne le chemin du fichier si toutes les étapes réussissent, sinon false.
     */
    public function execute(): string|false
    {
        if (!$this->validateFilePresence()) {
            return false;
        }

        if (!$this->validateFileSize()) {
            return false;
        }

        if (!$this->validateFileType()) {
            return false;
        }

        if (!$this->moveFile()) {
            return false;
        }

        return $this->pathFile();
    }
}
