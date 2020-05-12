<?php


namespace DocumentCreator\Model\Classes;

use \TCPDF as tcpdf;
class PDF extends Document
{
    private $datearea;

    public function __construct($name, $data, $datearea, $storage)
    {
        parent::__construct($name . $datearea, $data, 'pdf', $storage);

        $this->datearea = $datearea;

        $this->file = new tcpdf();
    }

    public function preparePDFDoc($mode)
    {
        if ($mode == 'table') {
            $this->file->SetCreator(PDF_CREATOR);
            $this->file->SetTitle($this->getId());
            $this->file->SetSubject('BeispielUntertitel');

            // Header und Footer Informationen
            $this->file->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
            $this->file->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

            // Auswahl der Margins
            $this->file->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
            $this->file->SetHeaderMargin(PDF_MARGIN_HEADER);
            $this->file->SetFooterMargin(PDF_MARGIN_FOOTER);

            // Image Scale
            $this->file->setImageScale(PDF_IMAGE_SCALE_RATIO);

            // Schriftart
            $this->file->SetFont('dejavusans', '', 10);


            // Neue Seite
            $this->file->AddPage();

            // Fügt den HTML Code in das PDF Dokument ein
            $this->file->writeHTML($this->getData(), true, false, true, false, '');

            // set content-type
            header("Content-Type: application/pdf");

            // It will be called downloaded.pdf
            header("Content-Disposition:attachment;filename='downloaded.pdf'");

            // The PDF source is in original.pdf
            readfile($this->getId() . ".pdf");
        }
    }

    public function createDocument($doc_stamp = '')
    {
        echo $this->file->Output($this->getId(), 'S'); // TODO
    }
}