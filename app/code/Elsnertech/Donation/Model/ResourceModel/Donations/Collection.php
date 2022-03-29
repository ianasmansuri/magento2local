<?php

namespace Elsnertech\Donation\Model\ResourceModel\Donations;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Class Collection
 * @package Elsnertech\Donation\Model\ResourceModel\Donations
 */
class Collection extends AbstractCollection
{
    /**
     * Define resource model
     *
     * @return void
     */
    public function _construct()
    {
        $this->_init(
            'Elsnertech\Donation\Model\Donations',
            'Elsnertech\Donation\Model\ResourceModel\Donations'
        );
    }
}
