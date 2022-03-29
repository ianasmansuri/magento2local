<?php


namespace Elsnertech\Donation\Api\Data;

/**
 * Interface DonationsSearchResultsInterface
 * @package Elsnertech\Donation\Api\Data
 */
interface DonationsSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{

    public function getItems();

    public function setItems(array $items);
}
