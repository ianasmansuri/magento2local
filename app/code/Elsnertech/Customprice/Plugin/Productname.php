<?php
 
namespace Elsnertech\Customprice\Plugin;
 
class Productname
{
    public function afterGetName(\Magento\Catalog\Model\Product $subject, $result)
    {           
        $title =('second_name');
        return $result.'-'.$title                                                              ;
    }

}