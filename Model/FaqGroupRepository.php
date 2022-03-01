<?php

namespace Bluethink\Faq\Model;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Exception\NoSuchEntityException;
use Bluethink\Faq\Api\Data\FaqGroupInterface;
use Bluethink\Faq\Api\Data\FaqGroupSearchResultInterface;
use Bluethink\Faq\Api\Data\FaqGroupSearchResultInterfaceFactory;
use Bluethink\Faq\Api\FaqGroupRepositoryInterface;
use Bluethink\Faq\Model\ResourceModel\FaqGroup\CollectionFactory as FaqGroupCollectionFactory;
use Bluethink\Faq\Model\ResourceModel\FaqGroup\Collection;
use Bluethink\Faq\Model\ResourceModel\FaqGroup as FaqGroupResourceModel;

class FaqGroupRepository implements FaqGroupRepositoryInterface
{
    /**
     * @var FaqGroupFactory
     */
    private $faqGroupFactory;

    /**
     * @var FaqGroupCollectionFactory
     */
    private $faqGroupCollectionFactory;

    /**
     * @var FaqGroupSearchResultInterfaceFactory
     */
    private $searchResultFactory;

    /**
     * @var FaqGroupResourceModel
     */
    private $resourceModel;

    /**
     * @param FaqGroupResourceModel $resourceModel
     * @param FaqGroupFactory $faqGroupFactory
     * @param FaqGroupCollectionFactory $faqGroupCollectionFactory
     * @param FaqGroupSearchResultInterfaceFactory $faqGroupSearchResultInterfaceFactory
     */
    public function __construct(
        FaqGroupResourceModel $resourceModel,
        FaqGroupFactory $faqGroupFactory,
        FaqGroupCollectionFactory $faqGroupCollectionFactory,
        FaqGroupSearchResultInterfaceFactory $faqGroupSearchResultInterfaceFactory
    ) {
        $this->faqGroupFactory = $faqGroupFactory;
        $this->faqGroupCollectionFactory = $faqGroupCollectionFactory;
        $this->searchResultFactory = $faqGroupSearchResultInterfaceFactory;
        $this->resourceModel = $resourceModel;
    }

    /**
     * Get FaqGroup by Faqgroup_Id.
     *
     * @param int $id
     * @return mixed
     * @throws NoSuchEntityException
     */
    public function getById($id)
    {
        $faqGroup = $this->faqGroupFactory->create();
        $this->resourceModel->load($faqGroup, $id);
        if (!$faqGroup->getId()) {
            throw new NoSuchEntityException(__('Unable to find FaqGroup with ID "%1"', $id));
        }
        return $faqGroup;
    }

    /**
     * Save FaqGroup.
     *
     * @param FaqGroupInterface $faqGroup
     * @return FaqGroupInterface
     * @throws \Magento\Framework\Exception\AlreadyExistsException
     */
    public function save(FaqGroupInterface $faqGroup)
    {
        $this->resourceModel->save($faqGroup);
    }

    /**
     * Delete FaqGroup.
     *
     * @param FaqGroupInterface $faqGroup
     * @return mixed|void
     * @throws \Exception
     */
    public function delete(FaqGroupInterface $faqGroup)
    {
        $this->resourceModel->delete($faqGroup);
    }

    /**
     * Get FaqGroup List.
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return mixed
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        $collection = $this->faqGroupCollectionFactory->create();

        $this->addFiltersToCollection($searchCriteria, $collection);
        $this->addSortOrdersToCollection($searchCriteria, $collection);
        $this->addPagingToCollection($searchCriteria, $collection);

        $collection->load();

        return $this->buildSearchResult($searchCriteria, $collection);
    }

    /**
     * Filter Collection by SearchCriteria.
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @param Collection $collection
     * @return void
     */
    private function addFiltersToCollection(SearchCriteriaInterface $searchCriteria, Collection $collection)
    {
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
     * Sort Collection.
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @param Collection $collection
     * @return void
     */
    private function addSortOrdersToCollection(SearchCriteriaInterface $searchCriteria, Collection $collection)
    {
        foreach ((array)$searchCriteria->getSortOrders() as $sortOrder) {
            $direction = $sortOrder->getDirection() == SortOrder::SORT_ASC ? 'asc' : 'desc';
            $collection->addOrder($sortOrder->getField(), $direction);
        }
    }

    /**
     * Add Paging  to Collection.
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @param Collection $collection
     * @return void
     */
    private function addPagingToCollection(SearchCriteriaInterface $searchCriteria, Collection $collection)
    {
        $collection->setPageSize($searchCriteria->getPageSize());
        $collection->setCurPage($searchCriteria->getCurrentPage());
    }

    /**
     * Build SearchResult.
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @param Collection $collection
     * @return mixed
     */
    private function buildSearchResult(SearchCriteriaInterface $searchCriteria, Collection $collection)
    {
        $searchResults = $this->searchResultFactory->create();

        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;
    }
}
