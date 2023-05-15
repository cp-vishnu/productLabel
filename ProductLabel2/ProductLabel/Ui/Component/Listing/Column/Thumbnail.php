<?php
namespace Codilar\ProductLabel\Ui\Component\Listing\Column;
 
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Ui\Component\Listing\Columns\Column;
 
class Thumbnail extends Column
{
    const URL_PATH_EDIT = 'productlabel/product/edit';
    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;
    /**
     * @var UrlInterface
     */
    protected $url;
 
    /**
     * Image constructor.
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param StoreManagerInterface $storeManager
     * @param UrlInterface $url
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        StoreManagerInterface $storeManager,
        UrlInterface $url,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->storeManager = $storeManager;
        $this->url = $url;
    }
 
    public function prepareDataSource(array $dataSource)
    {
        $mediaUrl = $this->storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA);
 
        if (isset($dataSource['data']['items'])) {
            $fieldName = 'product_image';
            foreach ($dataSource['data']['items'] as & $item) {
                if (!empty($item['product_image'])) {
                    $name = $item['product_image'];
                    $item[$fieldName . '_src'] = $mediaUrl.'tmp/imageUploader/images/'.$name;
                    $item[$fieldName . '_alt'] = '';
                    $item[$fieldName . '_link'] = $this->url->getUrl(static::URL_PATH_EDIT, [
                        'id' => $item['id']
                    ]);
                    $item[$fieldName . '_orig_src'] = $mediaUrl.'tmp/imageUploader/images/'.$name;
                }
            }
        }
        return $dataSource;
    }
 
}