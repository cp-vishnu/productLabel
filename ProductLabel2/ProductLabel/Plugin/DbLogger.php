<?php
namespace Codilar\ProductLabel\Plugin;

use Magento\Framework\DB\LoggerInterface as DbLoggerInterface;

class DbLogger
{
    public function beforeLog(DbLoggerInterface $logger, $query)
    {
        // log the query to a file or debug output
        file_put_contents(BP . '/var/log/sql.log', $query . "\n", FILE_APPEND);
        return [$query];
    }
}