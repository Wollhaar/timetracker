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
     * @return array
     */
    public function getSplittedTypes()
    {
        $types = explode(':', $this->type);
        return array('work_break' => $types[0], 'start_end' => $types[1]);
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return date('d M Y', $this->timestamp);
    }

    /**
     * @return mixed
     */
    public function getTime()
    {
        return date('H:i:s', $this->timestamp);
    }



    public function saveTime($document_stamp = null)
    {
        $this->document_stamp = $document_stamp;
        if (empty($this->document_stamp)) $this->document_stamp = $this->timestamp;
        $document = new Document($this->document_stamp, $this->timestamp . ',' . $this->type, 'txt', 'user');

        if ($this->type == 'work:start') {
            $document->createDocument();
        }
        else {
            $document->overrideDocument($this->document_stamp, $this->timestamp . ',' . $this->type);
        }
        return $this->document_stamp;
    }
}