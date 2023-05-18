<?php

namespace Codilar\ProductLabel\Model;

use Codilar\ProductLabel\Api\Data\ProductLabelInterface;
use Magento\Framework\Model\AbstractModel;

class Label extends AbstractModel implements ProductLabelInterface
{
    protected function _construct()
    {
        $this->_init('Codilar\ProductLabel\Model\ResourceModel\Label');
    }

    public function getId()
    {
        return $this->getData(self::ID);
    }

    public function setId($id)
    {
        $this->setData(self::ID, $id);
        return $this;
    }

    public function getName()
    {
        return $this->getData(self::NAME);
    }

    public function setName($name)
    {
        $this->setData(self::NAME, $name);
        return $this;
    }

    public function getStatus()
    {
        return $this->getData(self::STATUS);
    }

    public function setStatus($status)
    {
        $this->setData(self::STATUS, $status);
        return $this;
    }


    public function getProductImage()
    {
        return $this->getData(self::PRODUCT_IMAGE);
    }

    public function setProductImage($product_image)
    {
        $this->setData(self::PRODUCT_IMAGE, $product_image);
        return $this;
    }
    public function getFromDate()
    {
        return $this->getData(self::FROM_DATE);
    }

    public function setFromDate($fromdate)
    {
        $this->setData(self::FROM_DATE, $fromdate);
        return $this;
    }

    public function getToDate()
    {
        return $this->getData(self::TO_DATE);
    }

    public function setToDate($todate)
    {
        $this->setData(self::TO_DATE, $todate);
        return $this;
    }

    /**
     * Get Conditions Serialized
     *
     * @return mixed
     */
    public function getConditionsSerialized()
    {
        return $this->_getData(self::CONDITIONS_SERIALIZED);
    }

    /**
     * Set Conditions Serialized
     *
     * @param string $conditions
     * @return $this
     */
    public function setConditionsSerialized($conditions)
    {
        return $this->setData(self::CONDITIONS_SERIALIZED, $conditions);
    }
}
