<?php


namespace Elsnertech\Donation\Observer\Sales;

use Elsnertech\Donation\Model\DonationsFactory;
use Elsnertech\Donation\Model\Product\Type\Donation;
use Elsnertech\Donation\Model\DonationsRepository;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Sales\Model\Order;

class OrderItemSaveAfter implements ObserverInterface
{

    private $donationsModel;

    private $donationsRepository;

    private $order;

    public function __construct(
        DonationsFactory $donations,
        DonationsRepository $donationsRepository,
        Order $order
    ) {
        $this->donationsModel = $donations;
        $this->donationsRepository = $donationsRepository;
        $this->order = $order;
    }

    public function execute(
        Observer $observer
    ) {
    
        $event = $observer->getEvent();
    
        $orderItem = $event->getItem();

        if ($orderItem->getProductType() != Donation::TYPE_CODE) {
            return;
        }

        $donation = $this->donationsModel->create()->load($orderItem->getItemId(), 'order_item_id');
        if ($donation->getId()) {
            if ($orderItem->getQtyOrdered()==$orderItem->getQtyInvoiced()) {
                $donation->setInvoiced(1);
                $donation->save();
            }
            return;
        }

        $orderId = $orderItem->getOrderId();
        $order = $this->order->load($orderId);

        $donation->setName($orderItem->getName());
        $donation->setSku($orderItem->getSku());
        $donation->setAmount($orderItem->getPrice());
        $donation->setOrderId($orderId);
        $donation->setOrderItemId($orderItem->getItemId());
        $donation->setOrderStatus($order->getStatus());
        $donation->setInvoiced('');
        $donation->setCreatedAt($orderItem->getCreatedAt());
        $donation->save();
    }
}
