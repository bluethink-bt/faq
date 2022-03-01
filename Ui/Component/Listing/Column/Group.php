<?php

namespace Bluethink\Faq\Ui\Component\Listing\Column;

use Bluethink\Faq\Model\ResourceModel\FaqGroup\CollectionFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

class Group extends Column
{
    /**
     * @var CollectionFactory
     */
    protected $faqGroupCollection;

    /**
     * @var UiComponentFactory
     */
    protected $uiComponentFactory;

    /**
     * Group constructor.
     *
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param CollectionFactory $faqGroupCollection
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        CollectionFactory $faqGroupCollection,
        array $components = [],
        array $data = []
    ) {
        $this->faqGroupCollection = $faqGroupCollection;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Preparing Data Source.
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {

        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                $groups = explode(",", $item["group"]);
                $groupData = [];
                foreach ($groups as $group) {
                    $groupData[] = $this->faqGroupCollection->create()->getItemById($group)->getData('groupname');
                }

                $item['group'] = implode(",", $groupData);
            }
        }

        return $dataSource;
    }
}
