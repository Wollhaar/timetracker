<?php


namespace DocumentCreator\Model\Classes;


class Document
{
    private $id;
    private $data;
    private $formatting;
    private $storage;

    public function __construct($id = null, $data, $formatting, $storage)
    {
        $this->formatting = $formatting;
        $this->storage = $storage;

//        control if data is valid
        if (!is_string($data)) {
            if (is_array($data)) {
                $data = implode(',', $data);
            }
            elseif (is_a($data, 'Time') && is_int($data->getTime())) {
                $data = $data->getTime() . ',' . $data->getType();
            }
            else {
                return false;
            }
        }

        if (is_null($id)) $this->id = uniqid();
        else {
            $this->id = $id;
            $data = $this->getDataFromFile() . PHP_EOL . $data;
        }

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
     * create and fill Document
     * @param $path
     * @param $filename
     * @return string
     */
    public function createDocument($path, $doc_stamp)
    {
        if($this->checkPath($path)) {
            $file = $path . DIRECTORY_SEPARATOR . $doc_stamp . '.' . $this->formatting;
            file_put_contents($file, $this->data);
        }
        else $doc_stamp = false;

        return $doc_stamp;
    }


    public function getDataFromFile()
    {
        if ($this->storage == 'user') {
            $path = 'tracked' . DIRECTORY_SEPARATOR .
                date('Y') . DIRECTORY_SEPARATOR .
                date('m_M') . DIRECTORY_SEPARATOR;

            $filename = date('YmD') . '_' . $this->id . '.' . $this->formatting;
        }
        else return null;

        if ($this->checkPath($path)) {
            $data = file_get_contents($path . $filename);
        }
        return $data;
    }

    /**
     * add another work_stamp to file
     * @param $path
     * @param $doc_stamp
     */
    public function overrideDocument($path, $doc_stamp, $newData)
    {
        if (strpos($doc_stamp, $this->id) == -1) return false;
        $this->data = $newData;

        if ($this->checkPath($path)) {
            file_put_contents($path . $doc_stamp, $newData, FILE_APPEND);
        }
    }

    /**
     * check for existing path
     * @param $path
     * @return bool|int
     */
    private function checkPath($path)
    {
        $pathPpd = is_dir($path);
        if(!$pathPpd)$pathPpd = $this->makeDIR($path);

        if($this->storage == 'boss') {
            $path = 'tracked' . DIRECTORY_SEPARATOR . 'PDF' . DIRECTORY_SEPARATOR . USER;
            $pathPpd = $this->makeDIR($path);
        }

        return $pathPpd;
    }
    /**
     * create missing directories
     * @param $path
     * @return int
     */
    private function makeDIR($path)
    {
        $madeDIR = 0;
        $doDIRs = PWD;
        foreach (explode('/', $path) AS $dir) {
            if (is_dir($doDIRs .= DIRECTORY_SEPARATOR . $dir)){echo 'test'; continue;}
            if (mkdir($doDIRs, 0777)) $madeDIR++;
        }
        return $madeDIR;
    }
}