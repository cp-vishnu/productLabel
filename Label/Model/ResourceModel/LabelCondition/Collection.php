<?php

namespace Codilar\Label\Model\ResourceModel\LabelCondition;

use Codilar\Label\Model\LabelCondition as LabelConditionModel;
use Codilar\Label\Model\ResourceModel\LabelCondition as LabelConditionResourceModel;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(
            LabelConditionModel::class,
            LabelConditionResourceModel::class
        );
    }
}
