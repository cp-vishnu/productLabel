<?php

namespace Codilar\ProductLabel\Controller\Adminhtml\Product;

abstract class Rule extends \Magento\Backend\App\Action
{
    protected $coreRegistry = null;
    protected $fileFactory;
    protected $dateFilter;
    protected $ruleFactory;
    protected $logger;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Framework\App\Response\Http\FileFactory $fileFactory,
        \Magento\Framework\Stdlib\DateTime\Filter\Date $dateFilter,
        \Codilar\ProductLabel\Model\LabelFactory $ruleFactory,
        \Psr\Log\LoggerInterface $logger
    ) {
        parent::__construct($context);
        $this->coreRegistry = $coreRegistry;
        $this->fileFactory = $fileFactory;
        $this->dateFilter = $dateFilter;
        $this->ruleFactory = $ruleFactory;
        $this->logger = $logger;
    }

    protected function _initRule()
    {
        $rule = $this->ruleFactory->create();
        $this->coreRegistry->register(
            'current_rule',
            $rule
        );
        $id = (int) $this->getRequest()->getParam('id');

        if (!$id && $this->getRequest()->getParam('id')) {
            $id = (int) $this->getRequest()->getParam('id');
        }

        if ($id) {
            $this->coreRegistry->registry('current_rule')->load($id);
        }
    }

    protected function _initAction()
    {
        $this->_view->loadLayout();
        return $this;
    }
}
