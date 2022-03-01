<?php

namespace Bluethink\Faq\Model;

use Magento\Framework\Model\AbstractExtensibleModel;
use Bluethink\Faq\Api\Data\FaqGroupInterface;
use Bluethink\Faq\Model\ResourceModel\FaqGroup as ResourceModel;

class FaqGroup extends AbstractExtensibleModel implements FaqGroupInterface
{
    /**
     * FaqGroup _construct.
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(ResourceModel::class);
    }

    /**
     * @inheritdoc
     */
    public function getFaqgroupId()
    {
        return $this->getData(self::FAQGROUP_ID);
    }

    /**
     * @inheritdoc
     */
    public function setFaqgroupId($faqGroupId)
    {
        return $this->setData(self::FAQGROUP_ID, $faqGroupId);
    }

    /**
     * @inheritdoc
     */
    public function getGroupname()
    {
        return $this->getData(self::GROUPNAME);
    }

    /**
     * @inheritdoc
     */
    public function setGroupname($groupName)
    {
        return $this->setData(self::GROUPNAME, $groupName);
    }

    /**
     * @inheritdoc
     */
    public function getIcon()
    {
        return $this->getData(self::ICON);
    }

    /**
     * @inheritdoc
     */
    public function setIcon($icon)
    {
        return $this->setData(self::ICON, $icon);
    }

    /**
     * @inheritdoc
     */
    public function getSortOrder()
    {
        return $this->getData(self::SORT_ORDER);
    }

    /**
     * @inheritdoc
     */
    public function setSortOrder($sortOrder)
    {
        return $this->setData(self::SORT_ORDER, $sortOrder);
    }

    /**
     * @inheritdoc
     */
    public function getStatus()
    {
        return $this->getData(self::STATUS);
    }

    /**
     * @inheritdoc
     */
    public function setStatus($status)
    {
        return $this->setData(self::STATUS, $status);
    }
}
