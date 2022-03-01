<?php

namespace Bluethink\Faq\Controller\Adminhtml\FaqUser;

use Magento\Backend\App\Action\Context;
use Bluethink\Faq\Model\FaqUserFactory;
use Magento\Backend\App\Action;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;

class Delete extends Action
{
    /**
     * @var FaqUserFactory
     */
    protected $faqUserFactory;

    /**
     * Delete constructor.
     *
     * @param Context $context
     * @param FaqUserFactory $faqUserFactory
     */
    public function __construct(
        Context $context,
        FaqUserFactory $faqUserFactory
    ) {
        parent::__construct($context);
        $this->faqUserFactory = $faqUserFactory;
    }

    /**
     * Execute method.
     *
     * @return ResponseInterface|ResultInterface|void
     */
    public function execute()
    {
        $faqUserId = $this->getRequest()->getParam('user_faq_id');
        $resultRedirect = $this->resultRedirectFactory->create();

        if (!$faqUserId) {
            $this->messageManager->addError(__('FAQ does not exist'));
            return $resultRedirect->setPath('*/*/index');
        }

        try {
            $faqUser = $this->faqUserFactory->create();
            $faqUser->load($faqUserId);
            $faqUser->delete();
            $this->messageManager->addSuccess(__('FAQ has been successfully deleted with ID : %1.', $faqUserId));
            return $resultRedirect->setPath('*/*/index');
        } catch (\Exception $e) {
            $this->messageManager->addError($e->getMessage());
            return $resultRedirect->setPath('*/*/edit', ['user_faq_id' => $faqUserId]);
        }
    }
}
