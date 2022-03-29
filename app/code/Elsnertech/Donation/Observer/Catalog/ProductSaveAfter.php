<?php

namespace Elsnertech\Donation\Observer\Catalog;

use Elsnertech\Donation\Model\Product\Type\Donation;
use \Magento\CatalogInventory\Api\StockRegistryInterface;

class ProductSaveAfter implements \Magento\Framework\Event\ObserverInterface
{
    private $stockRegistry;

    public function __construct(StockRegistryInterface $stockRegistry)
    {
        $this->stockRegistry = $stockRegistry;
    }

    public function execute(
        \Magento\Framework\Event\Observer $observer
    ) {
        /* @var $product \Magento\Catalog\Model\Product */
        $product = $observer->getProduct();

        if ($product->getTypeId()== Donation::TYPE_CODE) {
            $stockItem = $this->stockRegistry->getStockItemBySku($product->getSku());

            if ($stockItem->getManageStock()) {
                $stockItem->setManageStock("0");
                $stockItem->setUseConfigManageStock("0");
                $stockItem->setIsInStock("1");
                $this->stockRegistry->updateStockItemBySku($product->getSku(), $stockItem);
            }
        }
    }
}
