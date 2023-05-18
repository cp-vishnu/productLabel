<?php

namespace Codilar\ProductLabel\Model\ResourceModel\Label;

use Codilar\ProductLabel\Model\Label;
use Codilar\ProductLabel\Model\ResourceModel\Label as LabelResourceModel;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(Label::class, LabelResourceModel::class);
    }
}
