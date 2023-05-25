<?php
namespace Codilar\Label\Helper;

use Magento\Framework\Registry;
use Magento\Catalog\Model\ProductFactory;
use Codilar\Label\Model\LabelConditionFactory;
use Magento\Catalog\Model\Design;

class LayoutHelper
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
        /** @var \Magento\Catalog\Model\Product $product */
        $product = $this->registry->registry('product');
        if (!$product && $productId= null) {
            return;
        }

        $productId = $product->getId();
        $productDetails = $this->productFactory->create()->load($productId);
        $ruleCollection = $this->labelConditionModel->create()->getCollection();
        $ruleCollection->addFieldToFilter('is_active', 1);

        foreach ($ruleCollection as $ruleKey => $ruleVal) {
            // check Product with condition
            if ($ruleVal->getConditions()->validate($productDetails)) {
                $rulecollection = $ruleCollection->addFieldToFilter('rule_id', $ruleVal->getId());
                foreach ($rulecollection as $rule) {
                    $this->ruleName = $rule->getProductImage();
                }
               
            }
        }
        return $this->ruleName;
    }
}
