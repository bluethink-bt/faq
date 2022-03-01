<?php

namespace Bluethink\Faq\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;

interface FaqGroupInterface extends ExtensibleDataInterface
{
    public const FAQGROUP_ID = 'faqgroup_id';

    public const GROUPNAME = 'groupname';

    public const ICON = 'icon';

    public const SORT_ORDER = 'sortorder';

    public const STATUS = 'status';

    /**
     * GetFaqgroupId method.
     *
     * @return mixed
     */
    public function getFaqgroupId();

    /**
     * SetFaqgroupId method.
     *
     * @param int $faqGroupId
     * @return mixed
     */
    public function setFaqgroupId($faqGroupId);

    /**
     * GetGroupname method.
     *
     * @return mixed
     */
    public function getGroupname();

    /**
     * SetGroupname method.
     *
     * @param string $groupName
     * @return mixed
     */
    public function setGroupname($groupName);

    /**
     * GetIcon method.
     *
     * @return mixed
     */
    public function getIcon();

    /**
     * SetIcon method.
     *
     * @param string $icon
     * @return mixed
     */
    public function setIcon($icon);

    /**
     * GetSortOrder method.
     *
     * @return mixed
     */
    public function getSortOrder();

    /**
     * SetSortOrder method.
     *
     * @param int $sortOrder
     * @return mixed
     */
    public function setSortOrder($sortOrder);

    /**
     * GetStatus method.
     *
     * @return mixed
     */
    public function getStatus();

    /**
     * SetStatus method.
     *
     * @param int $status
     * @return mixed
     */
    public function setStatus($status);
}
