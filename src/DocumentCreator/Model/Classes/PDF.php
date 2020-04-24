<?php


namespace DocumentCreator\Model\Classes;

use \TCPDF as tcpdf;
class PDF extends Document
{
    private $datearea;

    public function __construct($data, $formatting, $datearea, $storage)
    {
        parent::__construct($data, $formatting, $storage);

        $this->datearea = $datearea;

        $this->file = new tcpdf();
        $this->createDocument();
    }

    public function createDocument($path = '')
    {
        $this->file->Output(); // TODO
    }

//    public function fillDocument()
}