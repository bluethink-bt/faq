<?php

namespace Bluethink\Faq\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;

interface FaqInterface extends ExtensibleDataInterface
{
    public const FAQ_ID = 'faq_id';

    public const TITLE = 'title';

    public const CONTENT = 'content';

    public const GROUP = 'group';

    public const SORT_ORDER = 'sortorder';

    public const STATUS = 'status';

    /**
     * GetFaqId method.
     *
     * @return mixed
     */
    public function getFaqId();

    /**
     * SetFaqId method.
     *
     * @param int $faqId
     * @return mixed
     */
    public function setFaqId($faqId);

    /**
     * GetTitle method.
     *
     * @return mixed
     */
    public function getTitle();

    /**
     * SetTitle method.
     *
     * @param string $title
     * @return void
     */
    public function setTitle($title);

    /**
     * GetContent method.
     *
     * @return string
     */
    public function getContent();

    /**
     * SetContent method.
     *
     * @param string $content
     * @return void
     */
    public function setContent($content);

    /**
     * GetGroup method.
     *
     * @return string
     */
    public function getGroup();

    /**
     * SetGroup.
     *
     * @param string $group
     * @return void
     */
    public function setGroup($group);

    /**
     * GetSortOrder method.
     *
     * @return string
     */
    public function getSortOrder();

    /**
     * SetSortOrder method.
     *
     * @param string $sortOrder
     * @return void
     */
    public function setSortOrder($sortOrder);

    /**
     * GetStatus method.
     *
     * @return string
     */
    public function getStatus();

    /**
     * SetStatus method.
     *
     * @param string $status
     * @return void
     */
    public function setStatus($status);
}
