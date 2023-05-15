<?php
namespace Codilar\ProductLabel\Api;

use Codilar\ProductLabel\Api\Data\ProductLabelInterface;


interface ProductLabelRepositoryInterface
{
    public function save(ProductLabelInterface $item);

    public function getById($id);



    public function delete(ProductLabelInterface $item);

    // public function deleteById($id);
   
    public function getAllLabels();

    public function getNew();
}
