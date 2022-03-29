<?php


namespace Elsnertech\Donation\Plugin\Magento\Catalog\Block\Product;

class ListProduct
{

    public function aroundGetProductPrice(
        \Magento\Catalog\Block\Product\ListProduct $subject,
        \Closure $proceed,
        \Magento\Catalog\Model\Product $product
    ) {
        if ($product->getTypeId()=='donation') {
            return '';
        }
        return $proceed($product);
    }
}
