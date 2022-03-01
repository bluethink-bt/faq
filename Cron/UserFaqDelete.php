<?php

namespace Bluethink\Faq\Cron;

use Psr\Log\LoggerInterface;
use Bluethink\Faq\Model\ResourceModel\FaqUser\CollectionFactory as FaqUserCollection;

class UserFaqDelete
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var FaqUserCollection
     */
    private $faqUserCollection;

    /**
     * UserFaqDelete constructor.
     *
     * @param LoggerInterface $logger
     * @param FaqUserCollection $faqUserCollection
     */
    public function __construct(
        LoggerInterface $logger,
        FaqUserCollection $faqUserCollection
    ) {
        $this->logger = $logger;
        $this->faqUserCollection = $faqUserCollection;
    }

    /**
     * Execute method.
     *
     * @return void
     */
    public function execute()
    {
        $faqUser = $this->faqUserCollection->create();
        $faqUser->addFieldToFilter('decline_status', ['eq' => 1]);
        foreach ($faqUser as $faqUserData) {
            $faqUserData->delete();
            $this->logger->info('Deleted user faq with Id : ' . $faqUserData->getUserFaqId());
        }
    }
}
