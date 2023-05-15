<?php


namespace Codilar\ProductLabel\Block;

use Magento\Framework\View\Element\Template;

class Hello extends Template
{
    public function getText() 
    {
        return "Hello World";
    }

    public function getTime()
    {
        date_default_timezone_set('Asia/Kolkata');
        $current_time = date('h:i:s A');
        return $current_time;
    }
    
}