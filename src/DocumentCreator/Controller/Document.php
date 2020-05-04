<?php


namespace DocumentCreator\Controller\Document;


use DocumentCreator\Model\Classes\PDF;

class DocumentController
{
    public function listingDoc($doc_stamp)
    {
        $path = PWD . DIRECTORY_SEPARATOR . 'tracked' . DIRECTORY_SEPARATOR;
        if (!is_dir($path)) {
            mkdir($path, 0777, TRUE);
        }
        file_put_contents($path . 'track_' . USER . '.txt', $doc_stamp, FILE_APPEND);
    }

    public function getDoc($doc_stamp = 'actual')
    {
        $files = file_get_contents(PWD . '/tracked/track_' . USER . '.txt');
        if ($doc_stamp == 'actual') {
            end($files);
            $doc_stamp = current($files);
        }
        elseif(is_int($doc_stamp)) {
            $doc_stamp = array_search($doc_stamp, $files);
        }

        return $doc_stamp;
    }

    public function buildPDF()
    {
        $pdf = new PDF('LOREM IPSUM DOLORES', 'pdf', '2020-02-01:2020-03-30', 'boss');
        $pdf->testPDF();
    }
}