<?php

namespace Codilar\ProductLabel\Controller\Adminhtml\Product;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Session\SessionManagerInterface;
use Magento\Framework\Controller\ResultFactory;
use Codilar\ProductLabel\Api\ProductLabelRepositoryInterface;
use Codilar\ProductLabel\Api\Data\ProductLabelInterface;

class save extends Action
{

    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Codilar_VendorTable::entity';

    /**
     * @var ProductLabelRepositoryInterface
     */
    protected $labelRepository;
    
    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var SessionManagerInterface
     */
    protected $sessionManager;

    /**
     * @param Context $context
     * @param ProductLabelRepositoryInterface $labelRepository
     * @param PageFactory $resultPageFactory
     * @param SessionManagerInterface $sessionManager
     */
    public function __construct(
        Context $context,
        ProductLabelRepositoryInterface $labelRepository,
        PageFactory $resultPageFactory,
        SessionManagerInterface $sessionManager
    )
    {
        parent::__construct($context);
        $this->labelRepository = $labelRepository;
        $this->resultPageFactory = $resultPageFactory;
        $this->sessionManager = $sessionManager;
    }
    
    /**
     * Save action
     */
    public function execute()
    {   
        $resultRedirect = $this->resultRedirectFactory->create();
        $label = $this->labelRepository->getNew();
        
        $data = $this->getRequest()->getPost(); 
        
        try {
            if (!empty($data['id'])) {
                $label = $this->labelRepository->getById($data['id']);
            }
            
           // var_dump($data['from_date']);
           // die();

            $label->setName($data['name']);
            $label->setProductImage($data['product_image'][0]['name']);
            $label->setStatus($data['status']);
            $label->setFromDate($data['from_date']);
            $label->setToDate($data['to_date']);
            // var_dump($data['product_image'][0]);
            // die();
            $this->labelRepository->save($label);
            
            //check for `back` parameter
            if ($this->getRequest()->getParam('back')) { 
                return $resultRedirect->setPath('*/*/edit', ['id' => $label->getId(), '_current' => true, '_use_rewrite' => true]);
            }

            $this->messageManager->addSuccess(__('The Entity has been saved.'));

        } catch(\Exception $e) {
            $this->messageManager->addError(__($e->getMessage()));
        }
        
        return $resultRedirect->setPath('*/*/');
    }
}
