<?php

namespace Codilar\ProductLabel\Controller\Adminhtml\Product;

use Codilar\ProductLabel\Api\ProductLabelRepositoryInterface;
use Codilar\ProductLabel\Api\Data\ProductLabelInterface;
use Codilar\ProductLabel\Model\CouldNotDeleteException;
use Magento\Backend\App\Action;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;

class Delete extends Action
{
   

    /**
     * @var ProductLabelRepositoryInterface
     */
    private $labelRepository;

    /**
     * Delete constructor.
     *
     * @param Action\Context $context
     * @param ProductLabelRepositoryInterface $labelRepository
     */
    public function __construct(
        Action\Context $context,
        ProductLabelRepositoryInterface $labelRepository
    ) {
        parent::__construct($context);
        $this->labelRepository = $labelRepository;
    }

    /**
     * Delete action
     *
     * @return Redirect
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('id');

        

        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($id) {
            try {
                $label = $this->labelRepository->getById($id);
                $this->labelRepository->delete($label);
                // display success message
                $this->messageManager->addSuccess(__('Entity has been deleted.'));
                // go to grid
                return $resultRedirect->setPath('*/*/');
            } catch (NoSuchEntityException $e) {
                // display error message
                $this->messageManager->addError(__('We can\'t find the entity to delete.'));
                // go to grid
                return $resultRedirect->setPath('*/*/');
            } catch (CouldNotDeleteException $e) {
                // display error message
                $this->messageManager->addError($e->getMessage());
                // go back to edit form
                return $resultRedirect->setPath('*/*/edit', ['id' => $id]);
            } catch (LocalizedException $e) {
                // display error message
                $this->messageManager->addError($e->getMessage());
                // go to grid
                return $resultRedirect->setPath('*/*/');
            }
        }
        // display error message
        $this->messageManager->addError(__('We can\'t find the entity to delete.'));
        // go to grid
        return $resultRedirect->setPath('*/*/');
    }
}
