<?php

namespace Codilar\Label\Block;

use Codilar\Label\Helper\LayoutHelper;

class LabelPlp extends \Magento\Framework\View\Element\Template
{
    protected $layoutHelper;

    public function __construct(
        LayoutHelper $layoutHelper,
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

    public function imgaeUrl($productId)
    {
        $lmageName = $this->getLayoutHelper($productId);
        $baseUrl = $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
        $imageUrl = $baseUrl . 'tmp/imageUploader/images/'.$lmageName;
        if ($lmageName == null) {
            return null;
        }
        return $imageUrl;
    }
}
