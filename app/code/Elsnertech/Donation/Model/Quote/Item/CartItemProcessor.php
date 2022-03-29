<?php


namespace Elsnertech\Donation\Model\Quote\Item;

use Elsnertech\Donation\Helper\Serializer;
use Elsnertech\Donation\Model\DonationOptionsFactory;
use Magento\Quote\Api\Data\ProductOptionExtensionFactory;
use Magento\Quote\Model\Quote\Item\CartItemProcessorInterface;
use Magento\Quote\Api\Data\CartItemInterface;
use Magento\Framework\DataObject\Factory as DataObjectFactory;
use Magento\Quote\Model\Quote\ProductOptionFactory;


class CartItemProcessor implements CartItemProcessorInterface
{
    
    private $objectFactory;

    private $serializer;

    private $donationOptionsFactory;

    protected $extensionFactory;

    protected $productOptionFactory;

    public function __construct(
        DataObjectFactory $objectFactory,
        Serializer $serializer,
        DonationOptionsFactory $donationOptionsFactory,
        ProductOptionFactory $productOptionFactory,
        ProductOptionExtensionFactory $extensionFactory
    ) {
        $this->objectFactory = $objectFactory;
        $this->donationOptionsFactory = $donationOptionsFactory;
        $this->productOptionFactory = $productOptionFactory;
        $this->extensionFactory = $extensionFactory;
        $this->serializer = $serializer;
    }


    public function convertToBuyRequest(CartItemInterface $cartItem)
    {

        if ($cartItem->getProductOption()
            && $cartItem->getProductOption()->getExtensionAttributes()
            && $cartItem->getProductOption()->getExtensionAttributes()->getDonationOptions()
        ) {
            $donationOptions = $cartItem->getProductOption()->getExtensionAttributes()->getDonationOptions();

            if (!empty($donationOptions)) {
                return $this->objectFactory->create($donationOptions->getData());
            }
        }

        return null;
    }

    
    public function processOptions(CartItemInterface $cartItem)
    {
        $options = $this->getOptions($cartItem);
        if (!empty($options) && is_array($options)) {
            foreach ($options as $name => $value) {
                /** @var \Elsnertech\Donation\Model\DonationOptions $donationOptions */
                $donationOptions = $this->donationOptionsFactory->create();
                $donationOptions->setAmount($value);
            }

            $productOption = $cartItem->getProductOption()
                ? $cartItem->getProductOption()
                : $this->productOptionFactory->create();

            /** @var  \Magento\Quote\Api\Data\ProductOptionExtensionInterface $extensibleAttribute */
            $extensibleAttribute =  $productOption->getExtensionAttributes()
                ? $productOption->getExtensionAttributes()
                : $this->extensionFactory->create();

            $extensibleAttribute->setDonationOptions($donationOptions);
            $productOption->setExtensionAttributes($extensibleAttribute);
            $cartItem->setProductOption($productOption);
        }

        return $cartItem;
    }

    protected function getOptions(CartItemInterface $cartItem)
    {
        $options = !empty($cartItem->getOptionByCode('donation_options'))
            ? $this->serializer->unserialize($cartItem->getOptionByCode('donation_options')->getValue())
            : null;
        return is_array($options)
            ? $options
            : [];
    }
}
