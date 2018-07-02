<?php

namespace RC\Offices\Api;

interface OfficeRepositoryInterface 
{
    /**
     * @param int $id
     * @return \RC\Offices\Api\Data\OfficeInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById($id);

    /**
     * @param \RC\Offices\Api\Data\OfficeInterface $office
     * @return \RC\Offices\Api\Data\OfficeInterface
     */
    public function save(\RC\Offices\Api\Data\OfficeInterface $office);

    /**
     * @param \RC\Offices\Api\Data\OfficeInterface $office
     * @return void
     */
    public function delete(\RC\Offices\Api\Data\OfficeInterface $office);

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \RC\Offices\Api\Data\OfficeSearchResultInterface
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);
}
