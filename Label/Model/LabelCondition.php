<?php

namespace Codilar\Label\Model;

use Codilar\Label\Model\ResourceModel\LabelCondition as LabelConditionResourceModel;
use Magento\Quote\Model\Quote\Address;
use Magento\Rule\Model\AbstractModel;
use Codilar\Label\Api\Data\LabelInterface;

class LabelCondition extends AbstractModel implements LabelInterface
{
    protected $_eventPrefix = 'label';
    protected $_eventObject = 'rule';
    protected $condCombineFactory;
    protected $condProdCombineF;
    protected $validatedAddresses = [];
    protected $_selectProductIds;
    protected $_displayProductIds;

    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Framework\Stdlib\DateTime\TimezoneInterface $localeDate,
        \Magento\CatalogRule\Model\Rule\Condition\CombineFactory $condCombineFactory,
        \Magento\SalesRule\Model\Rule\Condition\Product\CombineFactory $condProdCombineF,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        $this->condCombineFactory = $condCombineFactory;
        $this->condProdCombineF = $condProdCombineF;
        parent::__construct($context, $registry, $formFactory, $localeDate, $resource, $resourceCollection, $data);
    }

    protected function _construct()
    {
        parent::_construct();
        $this->_init(LabelConditionResourceModel::class);
        $this->setIdFieldName('rule_id');
    }

    public function getId()
    {
        return $this->getData(self::ID);
    }

    public function setId($id)
    {
        $this->setData(self::ID, $id);
        return $this;
    }

    public function getName()
    {
        return $this->getData(self::NAME);
    }

    public function setName($name)
    {
        $this->setData(self::NAME, $name);
        return $this;
    }

    public function getStatus()
    {
        return $this->getData(self::STATUS);
    }

    public function setStatus($status)
    {
        $this->setData(self::STATUS, $status);
        return $this;
    }

    public function getProductImage()
    {
        return $this->getData(self::PRODUCT_IMAGE);
    }

    public function setProductImage($product_image)
    {
        $this->setData(self::PRODUCT_IMAGE, $product_image);
        return $this;
    }
    public function getFromDate()
    {
        return $this->getData(self::FROM_DATE);
    }

    public function setFromDate($fromdate)
    {
        $this->setData(self::FROM_DATE, $fromdate);
        return $this;
    }

    public function getToDate()
    {
        return $this->getData(self::TO_DATE);
    }

    public function setToDate($todate)
    {
        $this->setData(self::TO_DATE, $todate);
        return $this;
    }

    /**
     * Get Conditions Serialized
     *
     * @return mixed
     */
    public function getConditionsSerialized()
    {
        return $this->_getData(self::CONDITIONS_SERIALIZED);
    }

    /**
     * Set Conditions Serialized
     *
     * @param string $conditions
     * @return $this
     */
    public function setConditionsSerialized($conditions)
    {
        return $this->setData(self::CONDITIONS_SERIALIZED, $conditions);
    }

    /**
     * Get Actions Serialized
     *
     * @return mixed
     */
    public function getActionsSerialized()
    {
        return $this->_getData(self::ACTIONS_SERIALIZED);
    }

    /**
     * Set Actions Serialized
     *
     * @param string $actions
     * @return $this
     */
    public function setActionsSerialized($actions)
    {
        return $this->setData(self::ACTIONS_SERIALIZED, $actions);
    }

    public function getConditionsInstance()
    {
        return $this->condCombineFactory->create();
    }

    public function getActionsInstance()
    {
        return $this->condCombineFactory->create();
    }

    public function hasIsValidForAddress($address)
    {
        $addressId = $this->_getAddressId($address);
        return isset($this->validatedAddresses[$addressId]) ? true : false;
    }

    public function setIsValidForAddress($address, $validationResult)
    {
        $addressId = $this->_getAddressId($address);
        $this->validatedAddresses[$addressId] = $validationResult;
        return $this;
    }

    public function getIsValidForAddress($address)
    {
        $addressId = $this->_getAddressId($address);
        return isset($this->validatedAddresses[$addressId]) ? $this->validatedAddresses[$addressId] : false;
    }

    private function _getAddressId($address)
    {
        if ($address instanceof Address) {
            return $address->getId();
        }
        return $address;
    }

    public function getConditionsFieldSetId($formName = '')
    {
        return $formName . 'rule_conditions_fieldset_' . $this->getId();
    }

    public function getActionFieldSetId($formName = '')
    {
        return $formName . 'rule_actions_fieldset_' . $this->getId();
    }

    public function getMatchProductIds()
    {
        $productCollection = \Magento\Framework\App\ObjectManager::getInstance()->create(
            '\Magento\Catalog\Model\ResourceModel\Product\Collection'
        );
        $productFactory = \Magento\Framework\App\ObjectManager::getInstance()->create(
            '\Magento\Catalog\Model\ProductFactory'
        );
        $this->_selectProductIds = [];
        $this->setCollectedAttributes([]);
        $this->getConditions()->collectValidatedAttributes($productCollection);
        \Magento\Framework\App\ObjectManager::getInstance()->create(
            '\Magento\Framework\Model\ResourceModel\Iterator'
        )->walk(
            $productCollection->getSelect(),
            [[$this, 'callbackValidateProductCondition']],
            [
                'attributes' => $this->getCollectedAttributes(),
                'product' => $productFactory->create(),
            ]
        );
        return $this->_selectProductIds;
    }

    public function callbackValidateProductCondition($args)
    {
        $product = clone $args['product'];
        $product->setData($args['row']);
        $websites = $this->_getWebsitesMap();
        foreach ($websites as $websiteId => $defaultStoreId) {
            $product->setStoreId($defaultStoreId);

            if ($this->getConditions()->validate($product)) {
                $this->_selectProductIds[] = $product->getId();
            }
        }
    }

    protected function _getWebsitesMap()
    {
        $map = [];
        $websites = \Magento\Framework\App\ObjectManager::getInstance()->create(
            '\Magento\Store\Model\StoreManagerInterface'
        )->getWebsites();
        foreach ($websites as $website) {
            if ($website->getDefaultStore() === null) {
                continue;
            }
            $map[$website->getId()] = $website->getDefaultStore()->getId();
        }
        return $map;
    }
}
