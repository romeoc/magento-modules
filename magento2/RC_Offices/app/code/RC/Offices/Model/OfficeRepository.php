<?php 

namespace RC\Offices\Model;

class OfficeRepository implements \RC\Offices\Api\OfficeRepositoryInterface
{
    /**
     * @var \RC\Offices\Model\OfficeFactory
     */
    private $officeFactory;

    /**
     * @var \RC\Offices\Model\ResourceModel\Office\CollectionFactory
     */
    private $officeCollectionFactory;

    /**
     * @var \RC\Offices\Api\Data\OfficeSearchResultInterfaceFactory
     */
    private $searchResultFactory;

    /**
     * Constructor
     * @param \RC\Offices\Model\OfficeFactory $officeFactory
     * @param \RC\Offices\Model\ResourceModel\Office\CollectionFactory $officeCollectionFactory
     * @param \RC\Offices\Api\Data\OfficeSearchResultInterfaceFactory $officeSearchResultInterfaceFactory
     */
    public function __construct(
        \RC\Offices\Model\OfficeFactory $officeFactory,
        \RC\Offices\Model\ResourceModel\Office\CollectionFactory $officeCollectionFactory,
        \RC\Offices\Api\Data\OfficeSearchResultInterfaceFactory $officeSearchResultInterfaceFactory
    ) {
        $this->officeFactory = $officeFactory;
        $this->officeCollectionFactory = $officeCollectionFactory;
        $this->searchResultFactory = $officeSearchResultInterfaceFactory;
    }
    
    /**
     * Load an Office by ID
     * @param int $id
     * @return \RC\Offices\Model\OfficeFactory
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById($id)
    {
        $office = $this->officeFactory->create();
        $office->getResource()->load($office, $id);
        
        if (!$office->getId()) {
            throw new \Magento\Framework\Exception\NoSuchEntityException(__('Unable to find office with ID "%1"', $id));
        }
        
        return $office;
    }

    /**
     * Save Office
     * @param \RC\Offices\Api\Data\OfficeInterface $office
     * @return \RC\Offices\Api\Data\OfficeInterface
     */
    public function save(\RC\Offices\Api\Data\OfficeInterface $office)
    {
        $office->getResource()->save($office);
        return $office;
    }

    /**
     * Delete Office
     * @param \RC\Offices\Api\Data\OfficeInterface
     */
    public function delete(\RC\Offices\Api\Data\OfficeInterface $office)
    {
        $office->getResource()->delete($office);
    }
    
    /**
     * Get a list of offices
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return type
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria)
    {
        $collection = $this->collectionFactory->create();

        $this->addFiltersToCollection($searchCriteria, $collection);
        $this->addSortOrdersToCollection($searchCriteria, $collection);
        $this->addPagingToCollection($searchCriteria, $collection);

        $collection->load();

        return $this->buildSearchResult($searchCriteria, $collection);
    }

    /**
     * Add filters
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @param \RC\Offices\Model\ResourceModel\Office\Collection $collection
     */
    private function addFiltersToCollection(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria, 
        \RC\Offices\Model\ResourceModel\Office\Collection $collection
    ) {
        foreach ($searchCriteria->getFilterGroups() as $filterGroup) {
            $fields = $conditions = [];
            foreach ($filterGroup->getFilters() as $filter) {
                $fields[] = $filter->getField();
                $conditions[] = [$filter->getConditionType() => $filter->getValue()];
            }
            
            $collection->addFieldToFilter($fields, $conditions);
        }
    }

    /**
     * Add sort order
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @param \RC\Offices\Model\ResourceModel\Office\Collection $collection
     */
    private function addSortOrdersToCollection(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria, 
        \RC\Offices\Model\ResourceModel\Office\Collection $collection
    ) {
        foreach ((array) $searchCriteria->getSortOrders() as $sortOrder) {
            $direction = ($sortOrder->getDirection() == \Magento\Framework\Api\SortOrder::SORT_ASC) 
                ? \Magento\Framework\Api\SortOrder::SORT_ASC 
                : \Magento\Framework\Api\SortOrder::SORT_DESC;
            
            $collection->addOrder($sortOrder->getField(), $direction);
        }
    }

    /**
     * Add pagination
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @param \RC\Offices\Model\ResourceModel\Office\Collection $collection
     */
    private function addPagingToCollection(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria, 
        \RC\Offices\Model\ResourceModel\Office\Collection $collection
    ) {
        $collection->setPageSize($searchCriteria->getPageSize());
        $collection->setCurPage($searchCriteria->getCurrentPage());
    }

    /**
     * Build Search Result
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @param \RC\Offices\Model\ResourceModel\Office\Collection $collection
     */
    private function buildSearchResult(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria, 
        \RC\Offices\Model\ResourceModel\Office\Collection $collection
    ) {
        $searchResults = $this->searchResultFactory->create();

        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;
    }
}
