<?php

namespace MagicMonkey\Framework\Tool\FileManager;

/**
 * Class FileManager
 * @package MagicMonkey\Framework\Tool\FileManager
 */
class FileManager
{
    /**
     * Permet d'uploader un fichier
     * @param $file
     * @param $targetDir
     * @return string
     */
    public function upload($file, $targetDir)
    {
        if ($targetDir != "" && $file != null) {
            if ($this->isUploaded($file)) {
                // Determine file's extension
                $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
                // Generate a unique name for the file before saving it
                $filePath = "img" . md5(uniqid()) . '.' . $ext;
                // Move the file to the directory
                $tmp_name = $file["tmp_name"];
                if (!is_dir($targetDir)) {
                    mkdir($targetDir, 0777, true);
                }
                move_uploaded_file($tmp_name, $targetDir . DS . $filePath);
                return $filePath;
            }
        }
        return "";
    }

    /**
     * Détermine si un fichier est "uploadé" ou non
     * @param $file
     * @return bool
     */
    public function isUploaded($file)
    {
        return file_exists($file['tmp_name']) && is_uploaded_file($file['tmp_name']);
    }

    /**
     * Permet de supprimer un fichier
     * @param $filePath
     * @param $targetDir
     */
    public function deleteFile($filePath, $targetDir)
    {
        unlink($targetDir . DS . $filePath);
    }
}
