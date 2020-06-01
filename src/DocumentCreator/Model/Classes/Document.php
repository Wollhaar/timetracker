<?php


namespace DocumentCreator\Model\Classes;


class Document
{
    private $id;
    private $data;
    private $formatting;
    private $storage;

    public function __construct($id, $data, $formatting, $storage)
    {
        $this->id = $id;
        $this->formatting = $formatting;
        $this->storage = $storage;

//        control if data is valid
        if (!is_string($data)) {
            if (is_array($data)) {
                $data = implode(',', $data);
            }
        elseif (is_a($data, 'Time') && is_int($data->getTimestamp())) {
                $data = $data->getTimestamp() . ',' . $data->getType();
            }
        else {
                $this->case = 'No Data'; // TODO
            }
        }

        $this->path = $this->buildPath();

        if ($formatting == 'txt') $data = $this->getDataFromFile() . PHP_EOL . $data;
        $this->data = $data;
    }



    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * create and fill Document
     * @param string $doc_stamp
     */
    public function createDocument($doc_stamp = '')
    {
        if($this->checkPath()) {
            if (empty($doc_stamp)) $doc_stamp = $this->id;
            $file = $this->path . $doc_stamp . '.' . $this->formatting;
            file_put_contents($file, $this->data . PHP_EOL);
        }
    }

    /**
     * @return false|string
     */
    public function getDataFromFile()
    {
        $path = $this->path;
        $filename = $this->id . '.' . $this->formatting;

        if ($this->checkPath()) {
            return file_get_contents($path . $filename);
        }
        return 'Nothing found';
    }

    /**
     * add another work_stamp to file
     * @param $doc_stamp
     * @param $newData
     */
    public function overrideDocument($doc_stamp, $newData)
    {
        if ($this->checkPath()) {
            file_put_contents($this->path . $doc_stamp . '.' .$this->formatting, $newData . PHP_EOL, FILE_APPEND);
        }
    }

    public function buildPath()
    {
        switch ($this->storage)
        {
            case 'user':
                $path =  PWD . DIRECTORY_SEPARATOR . 'tracked' . DIRECTORY_SEPARATOR .
                date('Y', $this->id) . DIRECTORY_SEPARATOR .
                date('m_M', $this->id) . DIRECTORY_SEPARATOR;
                break;

            case 'boss':
                $path = PWD . DIRECTORY_SEPARATOR . 'tracked' . DIRECTORY_SEPARATOR .
                'boss' . DIRECTORY_SEPARATOR;
                break;

                default :
                    $path = PWD . DIRECTORY_SEPARATOR . 'tracked' . DIRECTORY_SEPARATOR;
        }

        return $path;
    }

    /**
     * check for existing path
     * @return bool|int
     */
    public function checkPath()
    {
        $pathPpd = is_dir($this->path);
        if(!$pathPpd)$pathPpd = $this->makeDIR();

        return $pathPpd;
    }

    /**
     * create missing directories
     * @return int
     */
    private function makeDIR()
    {
        $madeDIR = 0;
        $doDIRs = DIRECTORY_SEPARATOR;
        foreach (explode(DIRECTORY_SEPARATOR, $this->path) AS $dir) {
            if (is_dir($doDIRs .= $dir . DIRECTORY_SEPARATOR)) continue;
            if (mkdir($doDIRs, 0777, TRUE)) $madeDIR++;
        }
        return $madeDIR;
    }
}