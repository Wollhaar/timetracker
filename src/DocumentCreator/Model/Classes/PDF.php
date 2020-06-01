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

        $this->file = new tcpdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    }

    public function getDatearea()
    {
        return $this->datearea;
    }

    public function preparePDFDoc($mode)
    {
        if ($mode == 'table') {
            $this->file->SetCreator(PDF_CREATOR);
            $this->file->SetTitle($this->getId());
            $this->file->SetSubject('BeispielUntertitel');

            // Header und Footer Informationen
            $this->file->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' test', PDF_HEADER_STRING);
            $this->file->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
            $this->file->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

            // set default monospaced font
            $this->file->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

            // Auswahl der Margins
            $this->file->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
            $this->file->SetHeaderMargin(PDF_MARGIN_HEADER);
            $this->file->SetFooterMargin(PDF_MARGIN_FOOTER);

            // set auto page breaks
            $this->file->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

            // Image Scale
            $this->file->setImageScale(PDF_IMAGE_SCALE_RATIO);

            // Schriftart
            $this->file->SetFont('dejavusans', '', 10);


            // Neue Seite
            $this->file->AddPage();

            // set font
            $this->file->SetFont('helvetica', 'B', 20);

            // add a page
            $this->file->AddPage();

            $this->file->Write(0, 'Example of HTML tables', '', 0, 'L', true, 0, false, false, 0);

            $this->file->SetFont('helvetica', '', 8);
            // Fügt den HTML Code in das PDF Dokument ein
            $this->file->writeHTML($this->getData(), true, false, false, false, '');

            // set content-type
//            header("Content-Type: application/pdf");
        }
    }

    // TODO: geht noch nicht
    public function createDocument($doc_stamp = '')
    {
        if(parent::checkPath()) {

//        echo $this->file->Output($this->getId(), 'S'); // TODO
            $this->file->Output($this->path . $this->getId(), 'I'); // TODO
//        echo $this->file->Output(); // TODO

            // It will be called downloaded.pdf
//            header("Content-Disposition:attachment;filename='" . $doc_stamp . ".pdf'");
            // The PDF source is in original.pdf
//        readfile($this->path . $this->getId() . ".pdf"); // TODO: Searching filename Tracking_2020_04_Apr-2020_05_May2020_04_Apr-2020_05_May.pdf
        }
    }
}