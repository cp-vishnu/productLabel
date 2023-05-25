<?php

/**
 * LabelRepositoryInterface
 *
 * This interface defines methods to interact with  labels in the repository.
 *
 * @package Codilar\Label\Api
 */

namespace Codilar\Label\Api;

use Codilar\Label\Api\Data\LabelInterface;

/**
 * LabelRepositoryInterface
 *
 * This interface defines methods to interact with  labels in the repository.
 */

interface LabelRepositoryInterface
{
 
    /**
     * Save a  label.
     *
     * @param LabelInterface $item The  label to save.
     *
     * @return void
     */
    public function save(LabelInterface $item);
    /**
     * Get a  label by ID.
     *
     * @param mixed $id The ID of the  label.
     *
     * @return LabelInterface|null
     */
    public function getById($id);
    /**
     * Delete a  label.
     *
     * @param LabelInterface $item The  label to delete.
     *
     * @return void
     */
    public function delete(LabelInterface $item);
    /**
     * Get all  labels.
     *
     * @return LabelInterface[]
     */
    public function getAllLabels();
    /**
     * Get a new instance of the  label.
     *
     * @return LabelInterface
     */
    public function getNew();
}
