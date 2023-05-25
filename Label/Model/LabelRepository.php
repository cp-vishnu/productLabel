<?php

namespace Codilar\Label\Model;

use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\NoSuchEntityException;
use Codilar\Label\Api\Data\LabelInterface;
use Codilar\Label\Api\LabelRepositoryInterface;
use Codilar\Label\Model\ResourceModel\LabelCondition;
use Codilar\Label\Model\ResourceModel\LabelCondition\CollectionFactory;

/**
 * Class
 * @author vishnu.chengot
 */
class LabelRepository implements LabelRepositoryInterface
{

    /**
     * @var LabelFactory
     */
    private $labelFactory;

    /**
     * @var Label
     */
    private $labelResource;

    /**
     * @var LabelCollectionFactory
     */
    private $labelCollectionFactory;

    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;

    public function __construct(
        LabelConditionFactory $labelFactory,
        LabelCondition $labelResource,
        CollectionFactory $labelCollectionFactory,
        CollectionProcessorInterface $collectionProcessor
    ) {
        $this->labelFactory = $labelFactory;
        $this->labelResource = $labelResource;
        $this->labelCollectionFactory = $labelCollectionFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * @param int $id
     * @return \Codilar\Label\Api\Data\LabelInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById($id)
    {
        $label = $this->labelFactory->create();
        $this->labelResource->load($label, $id);
        if (!$label->getId()) {
            throw new NoSuchEntityException(__('Unable to find label with ID "%1"', $id));
        }
        return $label;
    }

    /**
     * @param \Codilar\Label\Api\Data\LabelInterface $label
     * @return \Codilar\Label\Api\Data\LabelInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(LabelInterface $label)
    {
        $this->labelResource->save($label);
        return $label;
    }

    /**
     * @param \Codilar\Label\Api\Data\LabelInterface $label
     * @return bool true on success
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function delete(LabelInterface $label)
    {
        try {
            $this->labelResource->delete($label);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(
                __('Could not delete the entry: %1', $exception->getMessage())
            );
        }

        return true;
    }

    /**
     * Retrieve all vendors
     *
     * @return \Codilar\Label\Api\Data\LabelInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getAllLabels($limit = null)
    {
        $collection = $this->labelCollectionFactory->create();

        if ($limit !== null) {
            $collection->setPageSize($limit);
        }
        return $collection->getItems();
    }

    /**
     * {@inheritdoc}
     */
    public function getNew()
    {
        return $this->labelFactory->create();
    }
}
