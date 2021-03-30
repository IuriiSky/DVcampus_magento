<?php
declare(strict_types=1);

namespace Iuriis\Chatbox\Plugin;

use Iuriis\Chatbox\Model\Message;
use Iuriis\Chatbox\Model\ResourceModel\Message\Collection as MessageCollection;
use Magento\Framework\DB\Select;
use Magento\Framework\DB\Transaction;

class MergeMessageAfterLogin
{
    /**
     * @var \Magento\Customer\Model\Session $customerSession
     */
    private $customerSession;

    /**
     * @var \Iuriis\Chatbox\Model\ResourceModel\Message\CollectionFactory $messageCollectionFactory
     */
    private $messageCollectionFactory;

    /**
     * @var \Magento\Framework\DB\TransactionFactory $transactionFactory
     */
    private $transactionFactory;

    /**
     * @param \Iuriis\Chatbox\Model\ResourceModel\Message\CollectionFactory $messageCollectionFactory
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Framework\DB\TransactionFactory $transactionFactory
     */
    public function __construct(
        \Iuriis\Chatbox\Model\ResourceModel\Message\CollectionFactory $messageCollectionFactory,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Framework\DB\TransactionFactory $transactionFactory
    ) {
        $this->messageCollectionFactory = $messageCollectionFactory;
        $this->customerSession = $customerSession;
        $this->transactionFactory = $transactionFactory;
    }

    /**
     * @return void
     * @throws \Exception
     */
    public function afterExecute($subject, $result)
    {
        if ($this->customerSession->isLoggedIn()) {
            $newMessageCollection = $this->messageCollectionFactory->create();
            $newMessageCollection->addFieldToFilter('author_id', $this->customerSession->getCustomerId())
                ->getSelect()
                ->order('message_id ' . Select::SQL_ASC)
                ->limit(1);

            $customerChatHash = $newMessageCollection->getFirstItem()->getData('chat_hash');

            /** @var MessageCollection $messageCollection */
            $messageCollection = $this->messageCollectionFactory->create();
            $messageCollection->addFieldToFilter('chat_hash', $this->customerSession->getChatHash());

            /** @var Transaction $transaction */
            $transaction = $this->transactionFactory->create();

            /** @var Message $message */
            foreach ($messageCollection as $message) {
                if (!$message->getAuthorId()) {
                    $message->setAuthorId($this->customerSession->getCustomerId());
                    $message->setAuthorName($this->customerSession->getCustomer()->getName());
                }

                $message->setChatHash((string)$customerChatHash);
                $transaction->addObject($message);
            }

            $transaction->save();

            $this->customerSession->setChatHash($customerChatHash);
        }

        return $result;
    }
}
