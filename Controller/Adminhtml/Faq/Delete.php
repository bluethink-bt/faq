<?php

namespace Bluethink\Faq\Controller\Adminhtml\Faq;

use Magento\Backend\App\Action\Context;
use Bluethink\Faq\Model\FaqFactory;
use Magento\Backend\App\Action;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;

class Delete extends Action
{
    /**
     * @var FaqFactory
     */
    protected $faqFactory;

    /**
     * Delete constructor.
     *
     * @param Context $context
     * @param FaqFactory $faqFactory
     */
    public function __construct(
        Context $context,
        FaqFactory $faqFactory
    ) {
        parent::__construct($context);
        $this->faqFactory = $faqFactory;
    }

    /**
     * Execute method.
     *
     * @return ResponseInterface|ResultInterface|void
     */
    public function execute()
    {
        $faqId = $this->getRequest()->getParam('faq_id');
        $resultRedirect = $this->resultRedirectFactory->create();

        if (!$faqId) {
            $this->messageManager->addError(__('FAQ does not exist'));
            return $resultRedirect->setPath('*/*/index');
        }

        try {
            $faq = $this->faqFactory->create();
            $faq->load($faqId);
            $faq->delete();
            $this->messageManager->addSuccess(__('FAQ has been successfully deleted with ID : %1.', $faqId));
            return $resultRedirect->setPath('*/*/index');
        } catch (\Exception $e) {
            $this->messageManager->addError($e->getMessage());
            return $resultRedirect->setPath('*/*/edit', ['faq_id' => $faqId]);
        }
    }
}
