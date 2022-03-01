<?php

namespace Bluethink\Faq\Controller\Adminhtml\FaqGroup;

use Magento\Backend\App\Action\Context;
use Bluethink\Faq\Model\FaqGroupFactory;
use Magento\Backend\App\Action;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;

class Delete extends Action
{
    /**
     * @var FaqGroupFactory
     */
    protected $faqGroupFactory;

    /**
     * Delete constructor.
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
        $faqGroupId = $this->getRequest()->getParam('faqgroup_id');
        $resultRedirect = $this->resultRedirectFactory->create();

        if (!$faqGroupId) {
            $this->messageManager->addError(__('FAQ Group does not exist'));
            return $resultRedirect->setPath('*/*/index');
        }

        try {
            $faqGroup = $this->faqGroupFactory->create();
            $faqGroup->load($faqGroupId);
            $faqGroup->delete();
            $this->messageManager->addSuccess(__('FAQ Group has been successfully deleted with ID : %1.', $faqGroupId));
            return $resultRedirect->setPath('*/*/index');
        } catch (\Exception $e) {
            $this->messageManager->addError($e->getMessage());
            return $resultRedirect->setPath('*/*/edit', ['faqgroup_id' => $faqGroupId]);
        }
    }
}
