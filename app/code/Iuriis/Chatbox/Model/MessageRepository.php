<?php
declare(strict_types=1);

namespace Iuriis\Chatbox\Model;

use Iuriis\Chatbox\Api\Data\ChatMessagesInterface;
use Iuriis\Chatbox\Api\Data\ChatMessagesSearchResultInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

class MessageRepository implements \Iuriis\Chatbox\Api\ChatMessagesRepositoryInterface
{
    /**
     * @var \Iuriis\Chatbox\Model\ResourceModel\Message\CollectionFactory $messagesCollectionFactory
     */
    private $messagesCollectionFactory;

    /**
     * @var \Iuriis\Chatbox\Api\Data\ChatMessagesSearchResultInterface $searchResultsFactory
     */
    private $searchResultsFactory;

    /**
     * @var \Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface $collectionProcessor
     **/
    private $collectionProcessor;

    /**
     * @var \Iuriis\Chatbox\Api\Data\ChatMessagesInterfaceFactory $messageDataFactory
     */
    private $messageDataFactory;

    /**
     * MessageRepository constructor.
     * @param \Iuriis\Chatbox\Model\ResourceModel\Message\CollectionFactory $messagesCollectionFactory
     * @param \Iuriis\Chatbox\Api\Data\ChatMessagesSearchResultInterface $searchResultsFactory
     * @param \Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface $collectionProcessor
     * @param \Iuriis\Chatbox\Api\Data\ChatMessagesInterfaceFactory $messageDataFactory
     */
    public function __construct(
        \Iuriis\Chatbox\Model\ResourceModel\Message\CollectionFactory $messagesCollectionFactory,
        \Iuriis\Chatbox\Api\Data\ChatMessagesSearchResultInterface $searchResultsFactory,
        \Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface $collectionProcessor,
        \Iuriis\Chatbox\Api\Data\ChatMessagesInterfaceFactory $messageDataFactory
    ) {
        $this->collectionProcessor = $collectionProcessor;
        $this->messagesCollectionFactory = $messagesCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->messageDataFactory = $messageDataFactory;
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return ChatMessagesSearchResultInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria): ChatMessagesSearchResultInterface
    {
        $messagesCollection = $this->messagesCollectionFactory->create();
        $this->collectionProcessor->process($searchCriteria, $messagesCollection);
        $messages = [];

        /** @var Message $message */
        foreach ($messagesCollection as $message) {
            $data = $message->setData();
            $data['message'] = $message->getMessage();
            $data['created_at'] = $message->getCreatedAt();
            $data['author_name'] = $message->getCreatedAt();

            $messages[] = $this->messageDataFactory->create(['data' => $data]);
        }

        /** @var  ChatMessagesSearchResultInterface $searchResults */
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setTotalCount($messagesCollection->getSize());
        $searchResults->setItems($messages);

        return $searchResults;
    }

    public function save(ChatMessagesInterface $message): ChatMessagesInterface
    {
        // TODO: Implement save() method.
    }

    public function get(int $messageId): ChatMessagesInterface
    {
        // TODO: Implement get() method.
    }

    public function delete(ChatMessagesInterface $message): bool
    {
        // TODO: Implement delete() method.
    }

    public function deleteById(int $messageId): bool
    {
        // TODO: Implement deleteById() method.
    }
}