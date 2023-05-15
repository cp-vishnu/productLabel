<?php
namespace Codilar\ProductLabel\Api\Data;

interface ProductLabelInterface
{
    const ID = 'id';

    const NAME = 'name';

    const STATUS ='status';

    const PRODUCT_IMAGE = 'product_image';

    const FROM_DATE ='from_date';
    
    const TO_DATE ='to_date';


    public function getId();

    public function setId($id);

    public function getName();

    public function setName($name);

    public function getStatus();

    public function setStatus($status);

    public function getProductImage();

    public function setProductImage($product_image);

    public function getFromDate();

    public function setFromDate($fromdate);
    
    public function getToDate();

    public function setToDate($todate);

}
