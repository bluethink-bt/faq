<?php

namespace Bluethink\Faq\Model\ResourceModel\FaqUser;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Bluethink\Faq\Model\FaqUser as Model;
use Bluethink\Faq\Model\ResourceModel\FaqUser as ResourceModel;

class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'user_faq_id';

    /**
     * Collection _construct
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(Model::class, ResourceModel::class);
    }
}
