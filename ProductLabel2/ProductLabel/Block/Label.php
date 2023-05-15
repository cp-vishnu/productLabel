<?php

namespace Codilar\ProductLabel\Block;

use Codilar\ProductLabel\Api\Data\ProductLabelInterface;
use Codilar\ProductLabel\Model\ResourceModel\Label\CollectionFactory;
use Magento\Framework\View\Element\Template;

class Label extends Template
{
    /**
     * @var ProductLabelInterface
     */
    private $label;

    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    public function __construct(
        Template\Context $context,
        CollectionFactory $collectionFactory,
        array $data = []
    ) {
        $this->collectionFactory = $collectionFactory;
        parent::__construct($context, $data);
    }

    public function getLabelName(): string
    {
        $collection = $this->collectionFactory->create();

        $writer = new \Zend_Log_Writer_Stream(BP . '/var/log/custom.log');
$logger = new \Zend_Log();
$logger->addWriter($writer);
$logger->info(json_encode($collection->getData()));

        $label = $collection->getData();
        $fromDate = $label[0]['from_date'];
        $toDate = $label[0]['to_date'];

        $currentDate = date('Y-m-d');

        if ($currentDate >= $fromDate && $currentDate <= $toDate) {
            return $label[0]['name'];
        }

       
        return '';
    }


    public function getImageUrl(): string
{
    
    $collection = $this->collectionFactory->create();
    $labelData = $collection->getData()[0];
    $fromDate = $labelData['from_date'];
    $toDate = $labelData['to_date'];
    $currentDate = date('Y-m-d');
    $labelImage = $labelData['product_image'];
    $baseUrl = $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
    $imageUrl = $baseUrl . 'tmp/imageUploader/images/'.$labelImage;

    if ($currentDate >= $fromDate && $currentDate <= $toDate) {
            return $imageUrl;
        }

    return '' ;

    // '<img src="' . $imageUrl . '" />';
}


}
