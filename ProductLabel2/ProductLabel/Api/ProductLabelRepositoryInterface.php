<?php

/**
 * ProductLabelRepositoryInterface
 *
 * This interface defines methods to interact with product labels in the repository.
 *
 * @package Codilar\ProductLabel\Api
 */

namespace Codilar\ProductLabel\Api;

use Codilar\ProductLabel\Api\Data\ProductLabelInterface;

/**
 * ProductLabelRepositoryInterface
 *
 * This interface defines methods to interact with product labels in the repository.
 */

interface ProductLabelRepositoryInterface
{
 
    /**
     * Save a product label.
     *
     * @param ProductLabelInterface $item The product label to save.
     *
     * @return void
     */
    public function save(ProductLabelInterface $item);
    /**
     * Get a product label by ID.
     *
     * @param mixed $id The ID of the product label.
     *
     * @return ProductLabelInterface|null
     */
    public function getById($id);
    /**
     * Delete a product label.
     *
     * @param ProductLabelInterface $item The product label to delete.
     *
     * @return void
     */
    public function delete(ProductLabelInterface $item);
    /**
     * Get all product labels.
     *
     * @return ProductLabelInterface[]
     */
    public function getAllLabels();
    /**
     * Get a new instance of the product label.
     *
     * @return ProductLabelInterface
     */
    public function getNew();
}
