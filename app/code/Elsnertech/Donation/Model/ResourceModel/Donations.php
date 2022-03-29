<?php

namespace Elsnertech\Donation\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Class Donations
 * @package Elsnertech\Donation\Model\ResourceModel
 */
class Donations extends AbstractDb
{
    /**
     * Define resource model
     *
     * @return void
     */
    public function _construct()
    {
        $this->_init('elsnertech_donations', 'donations_id');
    }
}
