<?php

namespace Bluethink\Faq\Controller\Adminhtml\FaqUser;

use Magento\Backend\App\Action\Context;
use Bluethink\Faq\Model\FaqUserFactory;
use Bluethink\Faq\Model\FaqFactory;
use Magento\Backend\App\Action;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;

class Save extends Action
{
    /**
     * @var FaqUserFactory
     */
    protected $faqUserFactory;

    /**
     * @var FaqFactory
     */
    protected $FaqFactory;

    /**
     * Save constructor.
     *
     * @param Context $context
     * @param FaqUserFactory $faqUserFactory
     * @param FaqFactory $faqFactory
     */
    public function __construct(
        Context $context,
        FaqUserFactory $faqUserFactory,
        FaqFactory $faqFactory
    ) {
        parent::__construct($context);
        $this->faqUserFactory = $faqUserFactory;
        $this->faqFactory = $faqFactory;
    }

    /**
     * Execute method.
     *
     * @return ResponseInterface|ResultInterface|void
     */
    public function execute()
    {
        $postData = $this->getRequest()->getParams();
        $authorizeStatus = $this->getRequest()->getParam('checkuserfaq');
        $resultRedirect = $this->resultRedirectFactory->create();

        if (!$postData) {
            return $resultRedirect->setPath('*/*/index');
        }

        $modelFaqUser = $this->faqUserFactory->create();
        $modelFaqUser = $modelFaqUser->load($postData['user_faq_id']);

        try {
            if ($postData['checkuserfaq']) {
                $postData = $this->_filterFaqGroupData($postData);
                $modelFaqUser->setData($postData)
                    ->setAuthorizeStatus($authorizeStatus)
                    ->setDeclineStatus(0)
                    ->setAddedStatus(0);

                if (isset($postData['user_faq_id'])) {
                    $modelFaqUser->setUserFaqId($postData['user_faq_id']);
                }

                $modelFaqUser->save();

                $this->messageManager->addSuccess(__('User FAQ has been Authorized.'));
            } else {
                $modelFaqUser->setData($postData)
                    ->setAuthorizeStatus(0)
                    ->setDeclineStatus(1)
                    ->setAddedStatus(0);
                $modelFaqUser->save();
                $this->messageManager->addSuccess(__('User Faq has Been Updated as You Declined'));
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
