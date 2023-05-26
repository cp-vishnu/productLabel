<?php
namespace Codilar\Label\Helper;

use Magento\Framework\Registry;
use Magento\Catalog\Model\ProductFactory;
use Codilar\Label\Model\LabelConditionFactory;
use Magento\Catalog\Model\Design;

class LayoutHelperPlp
{
    /**
     * @var Registry
     */
    protected $registry;
    protected $productFactory;
    protected $labelConditionModel;
    protected $design;
    protected $ruleName;

    /**
     * LayoutLoadBeforeHelper constructor.
     * @param Registry $registry
     */
    public function __construct(
        Registry $registry,
        ProductFactory $productFactory,
        LabelConditionFactory $labelConditionModel,
        Design $design
    ) {
        $this->registry = $registry;
        $this->productFactory = $productFactory;
        $this->labelConditionModel = $labelConditionModel;
        $this->design = $design;
    }

    /**
     * Apply the custom design logic.
     */
    public function applyCustomDesignLogic($productId = null)
    {
        
        $productDetails = $this->productFactory->create()->load($productId);
        $ruleCollection = $this->labelConditionModel->create()->getCollection();
        $currentDate = (new \DateTime())->format('Y-m-d');
        $ruleCollection->addFieldToFilter('is_active', 1)
            ->addFieldToFilter('from_date', ['lteq' => $currentDate])
            ->addFieldToFilter('to_date', ['gteq' => $currentDate]);
        $ruleData = [];
        foreach ($ruleCollection as $ruleKey => $ruleVal) {
            // check Product with condition
            if ($ruleVal->getConditions()->validate($productDetails)) {
                    $ruleData[$productDetails->getId()] = $ruleVal->getProductImage();
            }
        }
        return $ruleData;
    }
}
