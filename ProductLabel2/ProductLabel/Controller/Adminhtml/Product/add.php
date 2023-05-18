<?php

namespace Codilar\ProductLabel\Controller\Adminhtml\Product;

use Magento\Backend\App\Action;

class Add extends Action
{
    protected $resultPageFactory = false;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend((__('Product Label Manage')));

        return $resultPage;
    }
}
