<?php


namespace TrackerEngine\Model\Classes;

use DocumentCreator\Model\Classes\Document as Document;
class Time
{
    private $timestamp;
    private $type;

    public function __construct($timestamp, $type)
    {
        $this->timestamp = $timestamp;
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getTime()
    {
        return $this->timestamp;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }



    public function saveTime($path = null, $document_stamp = null)
    {
        $docID = strstr(strstr($document_stamp, '_'), '.', TRUE);
        $document = new Document($docID, $this->timestamp . ',' . $this->type, 'txt', 'user');

        if (empty($path)) {
            $path = PWD . DIRECTORY_SEPARATOR .
                'tracked' . DIRECTORY_SEPARATOR .
                date('Y', $this->getTime()) . DIRECTORY_SEPARATOR .
                date('m_M', $this->getTime());
        }
        if (empty($this->document_stamp)) {
            $document_stamp = $this->timestamp . '_' . $document->getId();
            $this->document_stamp = $document->createDocument($path, $document_stamp);
        }
        else {
            $document->overrideDocument($path, $this->document_stamp, $this->timestamp . ',' . $this->type);
        }
        return $document_stamp;
    }
}