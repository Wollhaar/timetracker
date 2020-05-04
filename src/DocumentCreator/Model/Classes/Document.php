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
                return false;
            }
        }
        $data = $this->getDataFromFile() . PHP_EOL . $data;
        $this->data = $data;

        $this->id = $id;
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

            $filename = $this->id . '.' . $this->formatting;
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
        $doDIRs = DIRECTORY_SEPARATOR;
        foreach (explode(DIRECTORY_SEPARATOR, PWD . $path) AS $dir) {
            if (is_dir($doDIRs .= $dir . DIRECTORY_SEPARATOR)){echo 'test'; continue;}
            if (mkdir($doDIRs, 0777, TRUE)) $madeDIR++;
        }
        return $madeDIR;
    }
}