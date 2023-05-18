<?php

namespace Codilar\ProductLabel\Controller\Adminhtml\Product;

use Magento\Backend\App\Action;
use Magento\Framework\Controller\ResultFactory;

class Edit extends Action
{
    /**
     * Authorization level of a basic admin session
     *
     *
     * @see _isAllowed()
     */
    public const ADMIN_RESOURCE = 'Codilar_ProductLabel::entity';

    /**
     * @var \Magento\Framework\Registry
     */
    private $coreRegistry;

    /**
     * @var \Codilar\ProductLabel\Model\LabelFactory
     */
    private $labelFactory;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry $coreRegistry,
     * @param \Codilar\ProductLabel\Model\LabelFactory $labelFactory
 */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Codilar\ProductLabel\Model\LabelFactory $labelFactory
    ) {
        parent::__construct($context);
        $this->coreRegistry = $coreRegistry;
        $this->labelFactory = $labelFactory;
    }

    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $id = $this->getRequest()->getParams('id');

        $model = $this->labelFactory->create();
        if ($id) {
            $model = $model->load($id);
            if (!$model->getId()) {
                return $resultRedirect->setPath('productlabel/product/edit');
            }
            $this->coreRegistry->register('label_data', $model);

            $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
            $title = "Edit";
            $resultPage->setActiveMenu('Codilar_ProductLabel::label_menu');
            $resultPage->getConfig()->getTitle()->prepend($title);
            return $resultPage;
        }
    }
}
