<?php

namespace OpsWay\Migration\Reader\File;

use OpsWay\Migration\Reader\ReaderInterface;

class Csv implements ReaderInterface
{
    protected $file;
    protected $filename;
    protected $columns;

    public function __construct($params)
    {
        $this->filename = $params['filename'];
        $this->checkFileName();
        if (!($this->file = fopen($this->filename, 'r'))) {
            throw new \RuntimeException(sprintf('Can not open file "%s" for reading data.', $this->filename));
        }
        $this->columns = fgetcsv($this->file, $item);
    }

    /**
     * @return array|null
     */
    public function read()
    {
        $result = [];
        if (is_array($line = fgetcsv($this->file, $item))) {
            foreach ($line as $key=>$data) {
                $result[$this->columns[$key]] = $data;
            }
        }
        return $result;
    }

    public function __destruct()
    {
        if ($this->file) {
            fclose($this->file);
        }
    }

    private function checkFileName()
    {
        if (!file_exists($this->filename)) {
            throw new \RuntimeException(sprintf('File "%s" does not exists. Create it and run again.', $this->filename));
        }
    }
}