<?php

namespace Codilar\Label\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class LabelCondition extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('label_custom_condition', 'rule_id');
    }
}
