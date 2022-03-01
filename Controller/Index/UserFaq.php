<?php

namespace Bluethink\Faq\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\View\Result\Page;

class UserFaq extends Action
{
    /**
     * @var PageFactory
     */
    private $pageFactory;

    /**
     * UserFaq constructor.
     *
     * @param Context $context
     * @param PageFactory $pageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $pageFactory
    ) {
        parent::__construct($context);
        $this->pageFactory = $pageFactory;
    }

    /**
     * Execute method.
     *
     * @return Page
     */
    public function execute()
    {
        return $this->pageFactory->create();
    }
}
