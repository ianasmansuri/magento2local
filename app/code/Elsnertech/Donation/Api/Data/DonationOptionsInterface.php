<?php

namespace Elsnertech\Donation\Api\Data;

interface DonationOptionsInterface
{

    const AMOUNT = 'amount';

    public function getAmount();

    public function setAmount($amount);
}
