<?php

namespace Bluethink\Faq\Cron;

use Psr\Log\LoggerInterface;
use Bluethink\Faq\Model\ResourceModel\FaqUser\CollectionFactory as FaqUserCollection;
use Bluethink\Faq\Model\FaqFactory;

class UserFaqAdd
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
     * @var FaqFactory
     */
    private $faqFactory;

    /**
     * UserFaqAdd constructor.
     *
     * @param LoggerInterface $logger
     * @param FaqUserCollection $faqUserCollection
     * @param FaqFactory $faqFactory
     */
    public function __construct(
        LoggerInterface $logger,
        FaqUserCollection $faqUserCollection,
        FaqFactory $faqFactory
    ) {
        $this->logger = $logger;
        $this->faqUserCollection = $faqUserCollection;
        $this->faqFactory = $faqFactory;
    }

    /**
     * Execute method.
     *
     * @return void
     * @throws \Exception
     */
    public function execute()
    {
        $faqUser = $this->faqUserCollection->create();
        $faqUser->addFieldToFilter('added_status', ['eq' => 0])
            ->addFieldToFilter('authorize_status', ['eq' => 1]);
        foreach ($faqUser as $faqUserData) {
            $faq = $this->faqFactory->create();
            $faq->setData($faqUserData->getData());

            if ($faq->save()) {
                $faqUserData->setAddedStatus(1);
                $faqUserData->save();
                $this->logger->info(
                    'User Faq with id : ' . $faqUserData->getUserFaqId()
                    . ' is Saved with id : ' . $faq->getFaqId()
                );
            } else {
                $this->logger->info('User Faq with id : ' . $faqUserData->getUserFaqId() . ' is Not saved');
            }
        }
    }
}
