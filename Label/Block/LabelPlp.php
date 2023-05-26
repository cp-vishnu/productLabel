<?php

namespace Codilar\Label\Block;

use Codilar\Label\Helper\LayoutHelperPlp;

class LabelPlp extends \Magento\Framework\View\Element\Template
{
    protected $layoutHelper;

    public function __construct(
        LayoutHelperPlp $layoutHelper,
        \Magento\Framework\View\Element\Template\Context $context,
        array $data = []
    ) {
        $this->layoutHelper = $layoutHelper;
        parent::__construct($context, $data);
    }
    
    public function getLayoutHelper($productId)
    {   
        return $this->layoutHelper->applyCustomDesignLogic($productId);
    }

    public function imgaeUrl($lmageName)
    {
        $baseUrl = $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
        $imageUrl = $baseUrl . 'tmp/imageUploader/images/'.$lmageName;
        return $imageUrl;
    }
}
