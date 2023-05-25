<?php

namespace Codilar\Label\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Codilar\Label\Api\LabelRepositoryInterface;
use Codilar\Label\Api\Data\LabelInterface;

class Delete extends Action
{
    
    /**
     * @var LabelRepositoryInterface
     */
    private $labelRepository;

    public function __construct(
        Action\Context $context,
        LabelRepositoryInterface $labelRepository
    ) {
        parent::__construct($context);
        $this->labelRepository = $labelRepository;
    }

    public function execute()
    {
        $id = $this->getRequest()->getParam('rule_id');
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($id) {
            try {
                $label = $this->labelRepository->getById($id);
                $this->labelRepository->delete($label);
                $this->messageManager->addSuccess(__('The rule is deleted successfully.'));
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
                return $resultRedirect->setPath('*/*/edit', ['rule_id' => $id]);
            }
        }
        $this->messageManager->addError(__('The rule does not exist'));
        return $resultRedirect->setPath('*/*/');
    }
}
