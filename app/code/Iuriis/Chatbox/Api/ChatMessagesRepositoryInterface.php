<?php

declare(strict_types=1);

namespace Iuriis\Chatbox\Api;

use Iuriis\Chatbox\Api\Data\ChatMessagesInterface;
use Iuriis\Chatbox\Api\Data\ChatMessagesSearchResultInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

interface ChatMessagesRepositoryInterface
{
    /**
     * Save message item
     *
     * @param ChatMessagesInterface $message
     * @return ChatMessagesInterface
     */
    public function save(ChatMessagesInterface $message): ChatMessagesInterface;

    /**
     * Get customer messages by message_id
     *
     * @param int $messageId
     * @return ChatMessagesInterface
     */
    public function get(int $messageId): ChatMessagesInterface;

    /**
     * Get list of customer messages
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return \Iuriis\Chatbox\Api\Data\ChatMessagesSearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): ChatMessagesSearchResultInterface;

    /**
     * Delete customer message object
     *
     * @param ChatMessagesInterface $message
     * @return bool
     */
    public function delete(ChatMessagesInterface $message): bool;

    /**
     * Delete customer preference by preference_id
     *
     * @param int $messageId
     * @return bool
     */
    public function deleteById(int $messageId): bool;
}