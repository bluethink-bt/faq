<?php

namespace Bluethink\Faq\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class FaqGroup extends AbstractDb
{
    /**
     * Collection _construct
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('bluethink_faqgroup', 'faqgroup_id');
    }
}
