<?php

namespace Elsnertech\Donation\Observer\Sales;

use Elsnertech\Donation\Model\Product\Type\Donation;

class QuoteItemSaveBefore implements \Magento\Framework\Event\ObserverInterface
{

    public function execute(
        \Magento\Framework\Event\Observer $observer
    ) {


        $item = $observer->getItem();

        if ($item->getProduct()->getTypeId()==Donation::TYPE_CODE) {
            $item->setNoDiscount(1);
        }

        return $this;
    }
}
