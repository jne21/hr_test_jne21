<?php

namespace OpsWay\Migration\Logger;

use OpsWay\Migration\Writer\File\Csv;

class OutOfStockLogger extends Csv
{
    protected $debug;

    public function __construct($params)
    {
        $this->filename = $params['out_of_stock_file'];
    }

    public function __invoke($item, $status, $msg)
    {
        if (!($item['qty']||$item['is_stock'])) {
            parent::write($item);
        }
    }
}
