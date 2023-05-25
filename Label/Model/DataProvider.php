<?php
namespace Codilar\Label\Model;

use Codilar\Label\Model\ResourceModel\LabelCondition\CollectionFactory;
use Magento\Backend\Model\UrlInterface;
use Magento\Framework\Filesystem;
use Magento\Framework\Filesystem\Driver\File\Mime;
use Magento\Store\Model\StoreManagerInterface;

class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    protected $loadedData;

    protected $rowCollection;

    protected $request;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var Filesystem\Directory\ReadInterface
     */
    protected $mediaDirectory;

    /**
     * @var Mime
     */
    protected $mime;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        \Magento\Framework\App\RequestInterface $request,
        StoreManagerInterface $storeManager,
        Filesystem $filesystem,
        Mime $mime,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();
        $this->rowCollection = $collectionFactory;
        $this->request = $request;
        $this->storeManager = $storeManager;
        $this->mime = $mime;
        $this->mediaDirectory = $filesystem->getDirectoryRead(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA);
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        /** @var Rule $rule */
        // @codingStandardsIgnoreStart
        foreach ($items as $rule) {
            $rule->load($rule->getId());
            $ruledata = $rule->getData();
            $image = $rule['product_image'];

            $imgDir = 'tmp/imageUploader/images';

            $baseUrl = $this->storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA);

            $fullImagePath = $this->mediaDirectory->getAbsolutePath($imgDir) . '/' . $image;

            $imageUrl = $baseUrl . $imgDir . '/' . $image;

            $stat = $this->mediaDirectory->stat($fullImagePath);

            $ruledata['product_image'] = null;

            $ruledata['product_image'][0]['url'] = $imageUrl;
            $ruledata['product_image'][0]['name'] = $image;
            $ruledata['product_image'][0]['size'] = $stat['size'];
            $ruledata['product_image'][0]['type'] = $this->mime->getMimeType($fullImagePath);

            $this->loadedData[$rule->getId()] = $ruledata;
        }
        // @codingStandardsIgnoreEnd
        return $this->loadedData;
    }
}
