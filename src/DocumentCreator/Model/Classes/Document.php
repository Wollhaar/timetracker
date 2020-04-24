<?php


namespace DocumentCreator\Model\Classes;


class Document
{
    const id = uniqid();

    private $data;
    private $formatting;
    private $storage;

    public function __construct($data, $formatting, $storage)
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

        $this->data = $data;
    }

    public function createDocument($path, $filename)
    {
        if($this->checkPath($path)) {
            $doc_stamp = $path . $filename . '.' . $this->formatting;
            file_put_contents($doc_stamp, $this->data);
//            $file = fopen($path . '/track_' . date('Y-m-d', $file_created_at) . '.txt', 'a');
//            fputcsv($file, $this->data, ',', '"', '\\');
//            fclose($file);
        }
        return $doc_stamp;
    }

    public function checkPath($path)
    {
        $pathPpd = is_dir($path);
        if(!$pathPpd)$pathPpd = mkdir($path, 0777, TRUE);
        if($this->storage == 'boss') {
            $path = 'tracked/PDF/' . USER;
            $pathPpd = mkdir($path, 0777, TRUE);
        }

        return $pathPpd;
    }

    /**
     * add another work_stamp to file TODO
     * @param $path
     * @param $doc_stamp
     */
    public function overrideDocument($path, $doc_stamp)
    {

    }
}