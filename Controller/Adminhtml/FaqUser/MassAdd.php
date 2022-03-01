<?php

namespace Bluethink\Faq\Controller\Adminhtml\FaqUser;

use Magento\Framework\Controller\ResultFactory;
use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use Bluethink\Faq\Model\ResourceModel\FaqUser\CollectionFactory;
use Bluethink\Faq\Model\FaqFactory;
use Magento\Backend\App\Action;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;

class MassAdd extends Action
{
    /**
     * @var Filter
     */
    protected $filter;

    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @var FaqFactory
     */
    private $faqFactory;

    /**
     * MassDelete constructor.
     * @param Context $context
     * @param ResultFactory $resultFactory
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     * @param FaqFactory $faqFactory
     */
    public function __construct(
        Context $context,
        ResultFactory $resultFactory,
        Filter $filter,
        CollectionFactory $collectionFactory,
        FaqFactory $faqFactory
    ) {
        $this->resultFactory = $resultFactory;
        $this->filter = $filter;
        $this->faqFactory = $faqFactory;
        $this->collectionFactory = $collectionFactory;
        parent::__construct($context);
    }

    /**
     * Execute method.
     *
     * @return ResponseInterface|ResultInterface
     * @throws LocalizedException
     */
    public function execute()
    {
        $collection = $this->filter->getCollection($this->collectionFactory->create());
        $collection->addFieldToFilter('added_status', ['eq' => 0])
            ->addFieldToFilter('authorize_status', ['eq' => 1]);
        $size = $collection->getSize();
        $recordAdded = 0;
        foreach ($collection as $record) {
            $faq = $this->faqFactory->create();
            $faq->setData($record->getData());

            if ($faq->save()) {
                $record->setAddedStatus(1);
                $record->save();
                $recordAdded++;
            }
        }
        $this->messageManager->addSuccess(__(
            'A total of %1 record(s) have been Added out of %2.',
            $recordAdded,
            $size
        ));

        return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)->setPath('*/*/index');
    }
}
