<?php

namespace Bluethink\Faq\Controller\Adminhtml\Faq;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Registry;
use Bluethink\Faq\Model\FaqFactory;
use Magento\Backend\Model\View\Result\Page;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Result\Page as FrameworkPage;
use Magento\Backend\App\Action;

class Edit extends Action
{
    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var Registry
     */
    private $coreRegistry;

    /**
     * @var FaqFactory
     */
    private $faqFactory;

    /**
     * Edit constructor.
     *
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param Registry $coreRegistry
     * @param FaqFactory $faqFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        Registry $coreRegistry,
        FaqFactory $faqFactory
    ) {
        parent::__construct($context);
        $this->coreRegistry = $coreRegistry;
        $this->resultPageFactory = $resultPageFactory;
        $this->faqFactory = $faqFactory;
    }

    /**
     * Execute method.
     *
     * @return Page|ResponseInterface|ResultInterface|FrameworkPage|void
     */
    public function execute()
    {
        $faqId = (int) $this->getRequest()->getParam('faq_id');
        $faqData = $this->faqFactory->create();

        if ($faqId) {
            $faqData = $faqData->load($faqId);
            $faqTitle = $faqData->getTitle();
            if (!$faqData->getFaqId()) {
                $this->messageManager->addError(__('FAQ Group no longer exist.'));
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('adminfaq/faq/index');
            }
        }

        $this->coreRegistry->register('faq_data', $faqData);
        $resultPage = $this->resultPageFactory->create();
        $title = $faqId ? __('Edit FAQ ') . $faqTitle : __('Add FAQ');
        $resultPage->getConfig()->getTitle()->prepend($title);
        return $resultPage;
    }
}
