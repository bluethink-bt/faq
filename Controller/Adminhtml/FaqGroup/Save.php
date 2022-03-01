<?php

namespace Bluethink\Faq\Controller\Adminhtml\FaqGroup;

use Magento\Backend\App\Action\Context;
use Bluethink\Faq\Model\FaqGroupFactory;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Backend\App\Action;

class Save extends Action
{
    /**
     * @var FaqGroupFactory
     */
    protected $faqGroupFactory;

    /**
     * Save constructor.
     *
     * @param Context $context
     * @param FaqGroupFactory $faqGroupFactory
     */
    public function __construct(
        Context $context,
        FaqGroupFactory $faqGroupFactory
    ) {
        parent::__construct($context);
        $this->faqGroupFactory = $faqGroupFactory;
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
            return $resultRedirect->setPath('adminfaq/faqgroup/index');
        }

        try {
            $model = $this->faqGroupFactory->create();
            if ($id = (int)$this->getRequest()->getParam('faqgroup_id')) {
                $model = $model->load($id);
                if ($id != $model->getId()) {
                    $this->messageManager->addErrorMessage(__('This FAQ Group no longer exists.'));
                    return $resultRedirect->setPath('*/*/index');
                }
            }
            $postData = $this->_filterFaqGroupData($postData);
            $model->setData($postData);

            if (isset($postData['faqgroup_id'])) {
                $model->setFaqgroupId($postData['faqgroup_id']);
            }

            $model->save();

            $this->messageManager->addSuccess(__('FAQ Group has been successfully saved.'));

            if ($this->getRequest()->getParam('back')) {
                return $resultRedirect->setPath('*/*/edit', ['faqgroup_id' => $model->getFaqgroupId()]);
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
        if (isset($data['icon'][0]['name'])) {
            $data['icon'] = $data['icon'][0]['name'];
        } else {
            $data['icon'] = null;
        }

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
