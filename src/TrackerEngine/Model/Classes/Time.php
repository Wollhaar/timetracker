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
    public function getTimestamp()
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

    /**
     * @return mixed
     */
    public function getTime()
    {
        return date('d M Y H:i', strtotime('+2 hours' . $this->timestamp));
    }



    public function saveTime($path = null, $document_stamp = null)
    {
        $this->document_stamp = $document_stamp;
        if (empty($this->document_stamp)) $this->document_stamp = $this->timestamp;
        $document = new Document($this->document_stamp, $this->timestamp . ',' . $this->type, 'txt', 'user');

        if (empty($path)) {
            $path = PWD . DIRECTORY_SEPARATOR .
                'tracked' . DIRECTORY_SEPARATOR .
                date('Y', $this->getTimestamp()) . DIRECTORY_SEPARATOR .
                date('m_M', $this->getTimestamp());
        }
        if ($this->type == 'work:start') {
            $document->createDocument($path, $document_stamp);
        }
        else {
            $document->overrideDocument($path, $this->document_stamp, $this->timestamp . ',' . $this->type);
        }
        return $document_stamp;
    }
}