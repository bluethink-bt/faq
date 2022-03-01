<?php

namespace Bluethink\Faq\Model;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Exception\NoSuchEntityException;
use Bluethink\Faq\Api\Data\FaqInterface;
use Bluethink\Faq\Api\Data\FaqSearchResultInterface;
use Bluethink\Faq\Api\Data\FaqSearchResultInterfaceFactory;
use Bluethink\Faq\Api\FaqRepositoryInterface;
use Bluethink\Faq\Model\ResourceModel\Faq\CollectionFactory as FaqCollectionFactory;
use Bluethink\Faq\Model\ResourceModel\Faq\Collection;
use Bluethink\Faq\Model\ResourceModel\Faq as FaqResourceModel;

class FaqRepository implements FaqRepositoryInterface
{
    /**
     * @var FaqFactory
     */
    private $faqFactory;

    /**
     * @var FaqCollectionFactory
     */
    private $faqCollectionFactory;

    /**
     * @var FaqSearchResultInterfaceFactory
     */
    private $searchResultFactory;

    /**
     * FaqRepository Constructor.
     *
     * @param FaqResourceModel $resourceModel
     * @param FaqFactory $faqFactory
     * @param FaqCollectionFactory $faqCollectionFactory
     * @param FaqSearchResultInterfaceFactory $faqSearchResultInterfaceFactory
     */
    public function __construct(
        FaqResourceModel $resourceModel,
        FaqFactory $faqFactory,
        FaqCollectionFactory $faqCollectionFactory,
        FaqSearchResultInterfaceFactory $faqSearchResultInterfaceFactory
    ) {
        $this->faqFactory = $faqFactory;
        $this->faqCollectionFactory = $faqCollectionFactory;
        $this->searchResultFactory = $faqSearchResultInterfaceFactory;
        $this->resourceModel = $resourceModel;
    }

    /**
     * Get Faq By Faq_id.
     *
     * @param int $id
     * @return mixed
     */
    public function getById($id)
    {
        $faq = $this->faqFactory->create();
        $this->resourceModel->load($faq, $id);
        if (!$faq->getId()) {
            throw new NoSuchEntityException(__('Unable to find Faq with ID "%1"', $id));
        }
        return $faq;
    }

    /**
     * Save Faq.
     *
     * @param FaqInterface $faq
     * @return FaqInterface
     */
    public function save(FaqInterface $faq)
    {
        $this->resourceModel->save($faq);
        return $faq;
    }

    /**
     * Delete Faq.
     *
     * @param FaqInterface $faq
     * @return mixed|void
     */
    public function delete(FaqInterface $faq)
    {
        $this->resourceModel->delete($faq);
    }

    /**
     * Get Faq List.
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return mixed
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        $collection = $this->faqCollectionFactory->create();

        $this->addFiltersToCollection($searchCriteria, $collection);
        $this->addSortOrdersToCollection($searchCriteria, $collection);
        $this->addPagingToCollection($searchCriteria, $collection);

        $collection->load();

        return $this->buildSearchResult($searchCriteria, $collection);
    }

    /**
     * Add filter to collection.
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
     * Add Paging to Collection.
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
