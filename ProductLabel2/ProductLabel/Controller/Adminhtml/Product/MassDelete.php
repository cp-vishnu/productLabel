<?php

namespace Codilar\ProductLabel\Controller\Adminhtml\Product;

use Magento\Backend\App\Action;
// use Codilar\VendorTable\Model\VendorFactory;
use Magento\Framework\Exception\LocalizedException;
use Codilar\ProductLabel\Api\ProductLabelRepositoryInterface;
use Codilar\ProductLabel\Api\Data\ProductLabelInterface;


class MassDelete extends Action
{
    /**
     * @var ProductLabelRepositoryInterface
     */
    private $labelsRepository;

    /**
     * MassDelete constructor.
     *
     * @param Action\Context $context
     * @param ProductLabelRepositoryInterface $labelsRepository
     */
    public function __construct(
        Action\Context $context,
        ProductLabelRepositoryInterface $labelsRepository
    ) {
        parent::__construct($context);
        $this->labelsRepository = $labelsRepository;
    }

    /**
     * MassDelete action
     *
     * @return \Magento\Framework\Controller\Result\Redirect
     */
    public function execute()
    {
        $ids = $this->getRequest()->getParam('selected');

        // var_dump($ids);
        // die();
        if (empty($ids)) {
            $this->messageManager->addError(__('Please select Labels(s) to delete.'));
        } else {
            try {
                foreach ($ids as $id) {

                    $labels = $this->labelsRepository->getById($id);
                    $this->labelsRepository->delete($labels);
                }
                $this->messageManager->addSuccess(__('Total of %1 Labels(s) have been deleted.', count($ids)));
            } catch (LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addError(__('We can\'t delete the Labels(s) right now. Please review the log and try again.'));
                $this->logger->critical($e);
            }
        }

        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setPath('*/*/');

        return $resultRedirect;
    }

    // /**
    //  * Check for permissions
    //  *
    //  * @return bool
    //  */
    // protected function _isAllowed()
    // {
    //     return $this->_authorization->isAllowed('Codilar_ProductLabels::productlabels_manage');
    // }
}