<?php
 
namespace Elsnertech\Customprice\Plugin;
 
class Productprice
{
    public function afterGetPrice(\Magento\Catalog\Model\Product $subject, $result)
    {
        if($result > 100){

        return $result + 100;
        }
        else{
          return  $result;
        }
    }

}