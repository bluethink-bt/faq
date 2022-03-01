<?php

namespace Bluethink\Faq\Model;

use Magento\Framework\Model\AbstractExtensibleModel;
use Bluethink\Faq\Model\ResourceModel\FaqUser as ResourceModel;

class FaqUser extends AbstractExtensibleModel
{
    /**
     * FaqUser _construct.
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(ResourceModel::class);
    }
}
