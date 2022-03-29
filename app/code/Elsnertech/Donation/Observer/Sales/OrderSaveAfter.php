<?php


namespace Elsnertech\Donation\Observer\Sales;

use Elsnertech\Donation\Model\Donations;
use Elsnertech\Donation\Model\Product\Type\Donation;
use Elsnertech\Donation\Model\DonationsRepository;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;


class OrderSaveAfter implements ObserverInterface
{

    private $donationsModel;

    private $donationsRepository;

    public function __construct(
        Donations $donations,
        DonationsRepository $donationsRepository
    ) {
        $this->donationsModel = $donations;
        $this->donationsRepository = $donationsRepository;
    }

    public function execute(
        Observer $observer
    ) {

        $order = $observer->getOrder();
        $orderId = $order->getId();


        $donations = $this->donationsRepository->getDonationsByOrderId($orderId);

        foreach ($donations as $donationItem) {
            $this->updateDonationItemData($donationItem, $order->getStatus());
        }
    }

    private function updateDonationItemData($donationItem, $orderStatus)
    {
        $donationItem->setOrderStatus($orderStatus);
        $donationItem->save();
    }
}
