<?php

namespace Elcodi\Component\Core\Services;

use ZipArchive;

class DownloadUtility
{

    /**
     * Crea lo stream per leggere e scaricare il file
     * @param string $filenamePath percorso del file
     * @param string $downloadName nome originale del file
     * @param string $mimeType tipo di file
     */
    public function downloadFile($filenamePath, $downloadName, $mimeType = '')
    {
        if (file_exists($filenamePath)) {
            header("Cache-Control: public");
            header("Content-Description: File Transfer");
            header("Content-Disposition: attachment; filename=" . $downloadName);
            if ($mimeType != '') {
                header("Content-Type: " . $mimeType);
            }

            header("Content-Transfer-Encoding: binary");

            // read the file from disk
            readfile($filenamePath);
        } else {
            echo "file $filenamePath doesn't exists";
            die();
        }
    }

    /**
     * Scarica una serie di files in un archivio.
     * @param  array $files array composto da una serie di coppie 'path', 'destination_filename'
     * @param  string $zipName nome del file zip creato
     * @return [type]          [description]
     */
    public function downloadFiles($array, $zipName)
    {
        if (file_exists('media/' . $zipName)) {
            unlink('media/' . $zipName);
        }

        $zip = new ZipArchive;
        $res = $zip->open('media/' . $zipName, ZipArchive::CREATE);

        $fileobjects = array();
        foreach ($array as $element) {
            if (file_exists($element['path'])) {
                $zip->addFile($element['path'], $element['destination_filename']);
            }

        }
        $zip->close();

        header("Cache-Control: public");
        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=" . $zipName);
        header("Content-Type: application/zip");
        header("Content-Transfer-Encoding: binary");

        // read the file from disk
        readfile('media/' . $zipName);
    }

}
