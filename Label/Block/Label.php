<?php

namespace Codilar\Label\Block;

use Codilar\Label\Helper\LayoutHelper;

class Label extends \Magento\Framework\View\Element\Template
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
 
    public function getLayoutHelper()
    {
        return $this->layoutHelper->applyCustomDesignLogic();
    }

    public function imgaeUrl()
    {
        $lmageName = $this->getLayoutHelper();
        $baseUrl = $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
        $imageUrl = $baseUrl . 'tmp/imageUploader/images/'.$lmageName;
        if ($lmageName == null) {
            return null;
        }
        return $imageUrl;
    }
}
