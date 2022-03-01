<?php

namespace Bluethink\Faq\Block\Index\Faq;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\Registry;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\View\LayoutInterface;
use Bluethink\Faq\Model\ResourceModel\Faq\CollectionFactory as FaqCollection;
use Bluethink\Faq\Model\ResourceModel\FaqGroup\CollectionFactory as FaqGroupCollection;
use Magento\Cms\Model\Template\FilterProvider;

class View extends Template
{
    /**
     * @var Registry
     */
    protected $coreRegistry;

    /**
     * @var LayoutInterface
     */
    protected $layout;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var FaqCollection
     */
    protected $faqCollection;

    /**
     * @var FaqGroupCollection
     */
    protected $faqGroupCollection;

    /**
     * View Constructor.
     *
     * @param Context $context
     * @param Registry $coreRegistry
     * @param FaqCollection $faqCollection
     * @param FaqGroupCollection $faqGroupCollection
     * @param StoreManagerInterface $storeManager
     * @param LayoutInterface $layout
     * @param FilterProvider $filterProvider
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $coreRegistry,
        FaqCollection $faqCollection,
        FaqGroupCollection $faqGroupCollection,
        StoreManagerInterface $storeManager,
        LayoutInterface $layout,
        FilterProvider $filterProvider,
        array $data = []
    ) {
        $this->coreRegistry = $coreRegistry;
        $this->storeManager = $storeManager;
        $this->faqCollection = $faqCollection;
        $this->faqGroupCollection = $faqGroupCollection;
        $this->layout = $layout;
        $this->filterProvider = $filterProvider;
        parent::__construct($context, $data);
    }

    /**
     * GetFaqGroupCollection method.
     *
     * @return mixed
     */
    public function getFaqGroupCollection()
    {
        return $this->faqGroupCollection->create();
    }

    /**
     * GetFaqCollectionByGroupId method.
     *
     * @param int $groupId
     * @return mixed
     */
    public function getFaqCollectionByGroupId($groupId)
    {
        return $this->getFaqCollection()->addFieldToFilter('group', ['eq' => $groupId]);
    }

    /**
     * GetFaqCollection method.
     *
     * @return mixed
     */
    public function getFaqCollection()
    {
        return $this->faqCollection->create();
    }

    /**
     * GetMediaUrl method.
     *
     * @return string
     */
    public function getMediaUrl()
    {
        return $this->storeManager->getStore()
                ->getBaseUrl(UrlInterface::URL_TYPE_MEDIA) . 'faq/tmp/icon/';
    }

    /**
     * Get User Faq Block.
     *
     * @return mixed
     */
    public function getUserFaqBlock()
    {
        return $this->layout
            ->createBlock(UserFaq::class)
            ->setTemplate('Bluethink_Faq::faq_add_new.phtml');
    }

    /**
     * Get filtered content.
     *
     * @param string $content
     * @return string
     * @throws \Exception
     */
    public function filterContent($content)
    {
        return $this->filterProvider->getPageFilter()->filter($content);
    }
}
