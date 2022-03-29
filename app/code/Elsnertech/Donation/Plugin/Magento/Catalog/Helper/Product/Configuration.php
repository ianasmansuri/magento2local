<?php


namespace Elsnertech\Donation\Plugin\Magento\Catalog\Helper\Product;

use Elsnertech\Donation\Helper\Data;


class Configuration
{
    
    protected $donationProductHelper;

    
    public function __construct(
        Data $donationProductHelper
    ) {
        $this->donationProductHelper = $donationProductHelper;
    }

    
    public function aroundGetOptions(
        \Magento\Catalog\Helper\Product\Configuration $subject,
        \Closure $proceed,
        \Magento\Catalog\Model\Product\Configuration\Item\ItemInterface $item
    ) {

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

            return array_merge($options, $proceed($item));
        }

        return $proceed($item);
    }
}
