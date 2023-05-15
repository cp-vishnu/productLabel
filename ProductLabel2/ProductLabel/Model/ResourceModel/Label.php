<?php


namespace Codilar\ProductLabel\Model\ResourceModel;


use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Label extends AbstractDb
{
    const MAIN_TABLE = 'label_tb';
    const ID_FIELD_NAME = 'id';

    protected function _construct()
    {
        $this->_init(self::MAIN_TABLE, self::ID_FIELD_NAME);
    }
}
