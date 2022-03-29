<?php

namespace Elsnertech\Donation\Plugin\Magento\Checkout\Block\Cart\Item;

use Elsnertech\Donation\Helper\Data;

class Renderer
{

    
    protected $donationProductHelper;

    
    public function __construct(
        Data $donationProductHelper
    ) {
    
        $this->donationProductHelper = $donationProductHelper;
    }

    
    public function afterGetProductOptions(
        \Magento\Checkout\Block\Cart\Item\Renderer $subject,
        $result
    ) {
        $item = $subject->getItem();
        $product = $item->getProduct();
        $typeId = $product->getTypeId();
        if ($typeId == \Elsnertech\Donation\Model\Product\Type\Donation::TYPE_CODE) {
            $itemOption = $item->getOptionByCode(Data::DONATION_OPTION_CODE);
            $options = [];
            $showOptionsInCart = false;
            if ($itemOption && $showOptionsInCart) {
                $options = $this->donationProductHelper->optionsJsonToMagentoOptionsArray(
                    $itemOption->getValue(),
                    $product
                );
            }

            return array_merge($options, $result);
        }

        return $result;
    }
}
