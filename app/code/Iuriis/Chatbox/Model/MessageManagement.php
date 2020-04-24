<?php
declare(strict_types=1);

namespace Iuriis\Chatbox\Model;

use Iuriis\Chatbox\Api\Data\ChatMessagesInterface;

class MessageManagement
{
    /**
     * @var \Magento\Framework\Api\FilterBuilder
     */
    private $filterBuilder;
    /**
     * @var \Magento\Framework\Api\SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;
    /**
     * @var MessageRepository
     */
    private $messageRepository;
    /**
     * @var \Magento\Framework\Api\SortOrderBuilder
     */
    private $sortOrderBuilder;

    /**
     * MessageManagement constructor.
     * @param \Iuriis\Chatbox\Model\MessageRepository $messageRepository
     * @param \Magento\Framework\Api\FilterBuilder $filterBuilder
     * @param \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder
     * @param \Magento\Framework\Api\SortOrderBuilder $sortOrderBuilder
     */
    public function __construct(
        \Iuriis\Chatbox\Model\MessageRepository $messageRepository,
        \Magento\Framework\Api\FilterBuilder $filterBuilder,
        \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder,
        \Magento\Framework\Api\SortOrderBuilder $sortOrderBuilder
    ) {
        $this->messageRepository = $messageRepository;
        $this->filterBuilder = $filterBuilder;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->sortOrderBuilder = $sortOrderBuilder;
    }

    /**
     * @param int $authorId
     * @return ChatMessagesInterface[]
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getCustomerMessagesId(int $authorId): array
    {
        $this->searchCriteriaBuilder->addSortOrder(
            $this->sortOrderBuilder
                ->setField('created_at')
                ->setDescendingDirection()
                ->setPageSize(10)
        );

        $this->searchCriteriaBuilder->addFilters([
            $this->filterBuilder
                ->setField('author_id')
                ->setValue($authorId)
                ->setConditionType('eq')
                ->create(),
            ]);
    }

    /**
     * @param string $chatHash
     * @return ChatMessagesInterface[]
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getCustomerMessagesChatHash(string $chatHash): array
    {
        $this->searchCriteriaBuilder->addSortOrder(
            $this->sortOrderBuilder
                ->setField('created_at')
                ->setDescendingDirection()
                ->setPageSize(10)
        );

        $this->searchCriteriaBuilder->addFilters([
            $this->filterBuilder
                ->setField('chat_hash')
                ->setValue($chatHash)
                ->setConditionType('eq')
                ->create(),
        ]);

        return  $this->messageRepository->getList($this->searchCriteriaBuilder->create())->getItems();
    }
}
