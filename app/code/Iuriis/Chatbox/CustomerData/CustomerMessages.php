<?php

namespace Iuriis\Chatbox\CustomerData;

use Iuriis\Chatbox\Model\ResourceModel\Message\Collection as MessageCollection;
use Magento\Framework\DB\Select;

class CustomerMessages implements \Magento\Customer\CustomerData\SectionSourceInterface
{
    /**
     * @var \Magento\Customer\Model\Session
     */
    private $customerSession;
    /**
     * @var \Iuriis\Chatbox\Model\ResourceModel\Message\CollectionFactory
     */
    private $messageCollectionFactory;

    /**
     * CustomerMessages constructor.
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Iuriis\Chatbox\Model\ResourceModel\Message\CollectionFactory $messageCollectionFactory
     */
    public function __construct(
        \Magento\Customer\Model\Session $customerSession,
        \Iuriis\Chatbox\Model\ResourceModel\Message\CollectionFactory $messageCollectionFactory
    ) {
        $this->customerSession = $customerSession;
        $this->messageCollectionFactory = $messageCollectionFactory;
    }

    /**
     * @inheritDoc
     */
    public function getSectionData(): array
    {
        $data = [];

        /** @var MessageCollection $messageCollection */
        $messageCollection = $this->messageCollectionFactory->create();

        if ($this->customerSession->isLoggedIn()) {
            $messageCollection->setOrder('created_at', Select::SQL_DESC)
                ->addFieldToFilter('author_id', $this->customerSession->getCustomerId())
                ->setPageSize(10);

            foreach ($messageCollection as $customerMessages) {
                $data[] = ['message' => $customerMessages->getMessage(),
                    'created_at' => $customerMessages->getCreatedAt(),
                    'author_name' => $customerMessages->getAuthorName()
                ];
            }
        } else {
            $messageCollection->setOrder('created_at', Select::SQL_DESC)
                ->addFieldToFilter('chat_hash', $this->customerSession->getChatHash())
                ->setPageSize(10);

            foreach ($messageCollection as $customerMessages) {
                $data[] = ['message' => $customerMessages->getMessage(),
                    'created_at' => $customerMessages->getCreatedAt(),
                    'author_name' => $customerMessages->getAuthorName()
                ];
            }
        }
        return $data;
    }
}
