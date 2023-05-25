<?php

namespace Codilar\Label\Controller\Adminhtml\Index;

use Codilar\Label\Model\LabelConditionFactory;
use Magento\Backend\App\Action;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Action\HttpPostActionInterface;

class Save extends Action implements HttpPostActionInterface
{

    protected $ruledatamodel;
    protected $dataPersistor;
    protected $productCollectionFactory;

    public function __construct(
        Action\Context $context,
        CollectionFactory $productCollectionFactory,
        LabelConditionFactory $ruledatamodel
    ) {
        $this->productCollectionFactory = $productCollectionFactory;
        $this->ruledatamodel = $ruledatamodel;
        parent::__construct($context);
    }

    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        if (isset($data['rule']['conditions'])) {
            
            $data['conditions'] = $data['rule']['conditions'];

        }
        if (isset($data['rule'])) {
            unset($data['rule']);
        }
        //  var_dump($data['conditions']);
        //     die();
        if (isset($data['product_image'])) {
            $data['product_image'] = $data['product_image'][0]['name'];
        }
        try {
            $model = $this->ruledatamodel->create();
            $id = $this->getRequest()->getParam('rule_id');
            if ($id) {
                $model->load($id);
            }
            if (!$model->getId() && $id) {
                $this->messageManager->addErrorMessage(__('This rule is no longer exists.'));
                return $resultRedirect->setPath('customlabel/index/index');
            }
            $model->loadPost($data);
            $model->save();
            $this->messageManager->addSuccess(__('Rule has been successfully saved.'));
            if ($this->getRequest()->getParam('back')) {
                if ($this->getRequest()->getParam('back') == 'add') {
                    return $resultRedirect->setPath('customlabel/index/add');
                } else {
                    return $resultRedirect->setPath(
                        'customlabel/index/edit',
                        [
                            'rule_id' => $model->getId(),
                        ]
                    );
                }
            }
        } catch (\Exception $e) {
            $writer = new \Zend_Log_Writer_Stream(BP . '/var/log/custom3.log');
            $logger = new \Zend_Log();
            $logger->addWriter($writer);
            $logger->info($e->getMessage());
            $this->messageManager->addException($e, __('Something went wrong while saving the data.'));
            return $resultRedirect->setPath('customlabel/index/add');
        }
        return $resultRedirect->setPath('customlabel/index/index');
    }
}
