<?php

namespace Bluethink\Faq\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Bluethink\Faq\Api\Data\FaqInterface;

interface FaqRepositoryInterface
{
    /**
     * GetById method.
     *
     * @param int $id
     * @return mixed
     */
    public function getById($id);

    /**
     * Save method.
     *
     * @param FaqInterface $faq
     * @return mixed
     */
    public function save(FaqInterface $faq);

    /**
     * Delete method.
     *
     * @param FaqInterface $faq
     * @return mixed
     */
    public function delete(FaqInterface $faq);

    /**
     * GetList method.
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return mixed
     */
    public function getList(SearchCriteriaInterface $searchCriteria);
}
