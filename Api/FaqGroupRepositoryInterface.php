<?php

namespace Bluethink\Faq\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Bluethink\Faq\Api\Data\FaqGroupInterface;

interface FaqGroupRepositoryInterface
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
     * @param FaqGroupInterface $faqGroup
     * @return mixed
     */
    public function save(FaqGroupInterface $faqGroup);

    /**
     * Delete method.
     *
     * @param FaqGroupInterface $faqGroup
     * @return mixed
     */
    public function delete(FaqGroupInterface $faqGroup);

    /**
     * GetList method.
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return mixed
     */
    public function getList(SearchCriteriaInterface $searchCriteria);
}
