<?php
declare(strict_types=1);

namespace Iuriis\Chatbox\Cron;

use Iuriis\Chatbox\Model\Message;

class UpdateStatusMessages
{
    /**
     * @var \Iuriis\Chatbox\Model\ResourceModel\Message
     */
    private $messageResource;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    /**
     * @var \Iuriis\Chatbox\Model\ResourceModel\Message\CollectionFactory
     */
    private $messageCollectionFactory;

    /**
     * @var \Magento\Framework\Stdlib\DateTime\TimezoneInterface
     */
    private $timezone;

    /**
     * UpdateStatusMessages constructor.
     * @param \Iuriis\Chatbox\Model\ResourceModel\Message\CollectionFactory $messageCollectionFactory
     * @param \Iuriis\Chatbox\Model\ResourceModel\Message $messageResource
     * @param \Psr\Log\LoggerInterface $logger
     * @param \Magento\Framework\Stdlib\DateTime\TimezoneInterface $timezone
     */
    public function __construct(
        \Iuriis\Chatbox\Model\ResourceModel\Message\CollectionFactory $messageCollectionFactory,
        \Iuriis\Chatbox\Model\ResourceModel\Message $messageResource,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Framework\Stdlib\DateTime\TimezoneInterface $timezone
    ) {
        $this->messageResource = $messageResource;
        $this->logger = $logger;
        $this->messageCollectionFactory = $messageCollectionFactory;
        $this->timezone = $timezone;
    }

    /**
     * Update status messages
     *
     * @return void
     * @throws \Magento\Framework\Exception\AlreadyExistsException
     */
    public function execute(): void
    {
        $chatHashCollection = $this->messageCollectionFactory->create();
        $allChatHash = $chatHashCollection->getColumnValues('chat_hash');
        $uniqChatHash = array_unique($allChatHash);

        /** @var \ArrayObject $uniqChatHash */
        foreach ($uniqChatHash as $hash) {

            /** @var Message $lastMessage */
            $messagesCollection = $this->messageCollectionFactory->create()
                ->addFieldToFilter('chat_hash', $hash);

            $lastMessage = $messagesCollection->getLastItem();
            $currentTime = $this->timezone->date()->format('Y-m-d H:i:s');
            $timeStamp = strtotime($currentTime);
            $createMessageTime = strtotime($lastMessage->getCreatedAt());
            $differenceTime = ($timeStamp - $createMessageTime);

            if ($lastMessage->getAuthorType() === Message::AUTHOR_TYPE_CUSTOMER
                && $lastMessage->getMessagePriority() === Message::MESSAGE_PRIORITY_REGULAR
                && $differenceTime > 1800) {
                $lastMessage->setMessagePriority(Message::MESSAGE_PRIORITY_WAITING);
                $this->messageResource->save($lastMessage);
            }
        }
    }
}
