<?php

namespace Bluethink\Faq\Controller\Adminhtml\Faq;

use Magento\Backend\App\Action\Context;
use Bluethink\Faq\Model\FaqFactory;
use Bluethink\Faq\Api\FaqRepositoryInterface;
use Magento\Backend\App\Action;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;

class Save extends Action
{
    /**
     * @var FaqFactory
     */
    protected $faqFactory;

    /**
     * @var FaqRepositoryInterface
     */
    protected $faqRepository;

    /**
     * @var RedirectFactory
     */
    private $resultRedirect;

    /**
     * Save constructor.
     *
     * @param Context $context
     * @param FaqFactory $faqFactory
     * @param FaqRepositoryInterface $faqRepository
     */
    public function __construct(
        Context $context,
        FaqFactory $faqFactory,
        FaqRepositoryInterface $faqRepository
    ) {
        parent::__construct($context);
        $this->faqFactory = $faqFactory;
        $this->faqRepository = $faqRepository;
    }

    /**
     * Execute method.
     *
     * @return ResponseInterface|ResultInterface|void
     */
    public function execute()
    {
        $postData = $this->getRequest()->getParams();
        $resultRedirect = $this->resultRedirectFactory->create();

        if (!$postData) {
            return $resultRedirect->setPath('*/*/');
        }

        try {
            $model = $this->faqFactory->create();
            if ($id = (int)$this->getRequest()->getParam('faq_id')) {
                $model = $model->load($id);
                if ($id != $model->getId()) {
                    $this->messageManager->addErrorMessage(__('This FAQ no longer exists.'));
                    return $resultRedirect->setPath('*/*/index');
                }
            }
            $postData = $this->_filterFaqGroupData($postData);
            $model->setData($postData);

            if (isset($postData['faq_id'])) {
                $model->setFaqId($postData['faq_id']);
            }

            $model->save();
            $this->messageManager->addSuccess(__('FAQ has been successfully saved.'));

            if ($this->getRequest()->getParam('back')) {
                return $resultRedirect->setPath('*/*/edit', ['faq_id' => $model->getFaqId()]);
            }
        } catch (\Exception $e) {
            $this->messageManager->addError(__($e->getMessage()));
        }
        return $resultRedirect->setPath('*/*/index');
    }

    /**
     * Filter faq group data
     *
     * @param array $rawData
     * @return array
     */
    protected function _filterFaqGroupData(array $rawData)
    {
        $data = $rawData;
        $cGroup = $data['customer_group'];
        if (isset($cGroup)) {
            $customerGroup = implode(',', $data['customer_group']);
            $data['customer_group'] = $customerGroup;
        }

        $stores = $data['storeview'];
        if (isset($stores)) {
            $store = implode(',', $data['storeview']);
            $data['storeview'] = $store;
        }

        return $data;
    }
}
