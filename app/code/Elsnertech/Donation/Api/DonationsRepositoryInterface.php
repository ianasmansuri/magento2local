<?php

namespace Elsnertech\Donation\Api;

/**
 * Interface DonationsRepositoryInterface
 * @package Elsnertech\Donation\Api
 */
interface DonationsRepositoryInterface
{

    public function save(
        \Elsnertech\Donation\Api\Data\DonationsInterface $donations
    );

    public function getById($donationsId);

    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );

    public function delete(
        \Elsnertech\Donation\Api\Data\DonationsInterface $donations
    );

    public function deleteById($donationsId);
}
