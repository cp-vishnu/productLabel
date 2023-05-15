<?php
namespace Codilar\ProductLabel\Model;

use Codilar\ProductLabel\Model\ResourceModel\Label\CollectionFactory;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Backend\Model\UrlInterface;
use Magento\Framework\Filesystem;
use Magento\Framework\Filesystem\Driver\File\Mime;

 
class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /**
     * @var array
     */
    protected $loadedData;


     /**
   * @var StoreManagerInterface
   */
  protected $storeManager;


   /** 
   * @var Filesystem\Directory\ReadInterface 
   */
  protected $mediaDirectory;


    /**
     * Dataprovider constructor
     *
     * @param string            $name
     * @param string            $primaryFieldName
     * @param string            $requestFieldName
     * @param CollectionFactory $faqCollectionFactory
     * @param StoreManagerInterface $storeManager
     * @param array             $meta
     * @param array             $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $faqCollectionFactory,
        StoreManagerInterface $storeManager,
        Filesystem $filesystem,
        Mime $mime,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $faqCollectionFactory->create();
        $this->storeManager = $storeManager;
        $this->mime = $mime;
        $this->mediaDirectory = $filesystem->getDirectoryRead(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA);
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }
    /**
     * Get the FAQ details
     */
    public function getData()

    {
        // var_dump('hai');
        // die();
   
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();

        foreach ($items as $faq) {
            $faqdata =$faq->getData();

            $image = $faq['product_image'];

            $imgDir ='tmp/imageUploader/images';

            $baseUrl =$this->storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA);

            $fullImagePath =$this->mediaDirectory->getAbsolutePath($imgDir).'/'.$image;

            $imageUrl = $baseUrl . $imgDir .'/' .$image;

            $stat = $this->mediaDirectory->stat($fullImagePath);



            $faqdata['product_image'] = null;

            $faqdata['product_image'][0]['url'] = $imageUrl;
            $faqdata['product_image'][0]['name'] = $image;
            $faqdata['product_image'][0]['size'] = $stat['size'];
            $faqdata['product_image'][0]['type'] = $this->mime->getMimeType($fullImagePath);

            $this->loadedData[$faq->getId()] = $faqdata;
        }

         // echo '<pre>'; print_r($this->loadedData); echo '</pre>';
        return $this->loadedData;
    }
}