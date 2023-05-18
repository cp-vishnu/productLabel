<?php

/**
 * ProductLabelInterface
 *
 * This interface represents the data structure for a product label.
 *
 * @package Codilar\ProductLabel\Api\Data
 */

namespace Codilar\ProductLabel\Api\Data;

/**
 * Interface ProductLabelInterface
 *
 * @package Codilar\ProductLabel\Api\Data
 */
interface ProductLabelInterface
{
    public const ID = 'id';

    public const NAME = 'name';

    public const STATUS = 'status';

    public const PRODUCT_IMAGE = 'product_image';

    public const FROM_DATE = 'from_date';

    public const TO_DATE = 'to_date';

    public const CONDITIONS_SERIALIZED = 'conditions_serialized';


    /**
     * Get the ID of the product label.
     *
     * @return mixed
     */
    public function getId();
    /**
     * Set the ID of the product label.
     *
     * @param mixed $id The ID value to set.
     *
     * @return void
     */
    public function setId($id);
    /**
     * Get the name of the product label.
     *
     * @return string
     */
    public function getName();
    /**
     * Set the name of the product label.
     *
     * @param string $name The name value to set.
     *
     * @return void
     */
    public function setName($name);
    /**
     * Get the status of the product label.
     *
     * @return int
     */
    public function getStatus();
    /**
     * Set the status of the product label.
     *
     * @param int $status The status value to set.
     *
     * @return void
     */
    public function setStatus($status);
    /**
     * Get the product image of the product label.
     *
     * @return string
     */
    public function getProductImage();
    /**
     * Set the product image of the product label.
     *
     * @param string $product_image The product image value to set.
     *
     * @return void
     */
    public function setProductImage($product_image);
    /**
     * Get the "from" date of the product label.
     *
     * @return string|null
     */
    public function getFromDate();
    /**
     * Set the "from" date of the product label.
     *
     * @param string|null $fromdate The "from" date value to set.
     *
     * @return void
     */
    public function setFromDate($fromdate);
    /**
     * Get the "to" date of the product label.
     *
     * @return string|null
     */
    public function getToDate();
    /**
     * Set the "to" date of the product label.
     *
     * @param string|null $todate The "to" date value to set.
     *
     * @return void
     */
    public function setToDate($todate);
    /**
     * Get the serialized conditions of the product label.
     *
     * @return string|null
     */
    public function getConditionsSerialized();
    /**
     * Set the serialized conditions of the product label.
     *
     * @param string|null $conditions The serialized conditions value to set.
     *
     * @return void
     */
    public function setConditionsSerialized($conditions);
}
