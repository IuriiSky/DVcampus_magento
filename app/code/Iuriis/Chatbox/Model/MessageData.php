<?php
declare(strict_types=1);

namespace Iuriis\Chatbox\Model;

use Iuriis\Chatbox\Api\Data\ChatMessagesInterface;

class MessageData extends \Magento\Framework\Api\AbstractSimpleObject implements
    \Iuriis\Chatbox\Api\Data\ChatMessagesInterface
{
    public function getAuthorType(): string
    {
        return (string) $this->_get(ChatMessagesInterface::AUTHOR_TYPE);
    }

    public function setAuthorType(string $authorType): ChatMessagesInterface
    {
        $this->setData(self::AUTHOR_TYPE, $authorType);
        return $this;
    }

    public function getAuthorId(): int
    {
        return (int) $this->_get(ChatMessagesInterface::AUTHOR_ID);
    }

    public function setAuthorId(int $authorId): ChatMessagesInterface
    {
        $this->setData(self::AUTHOR_ID, $authorId);
        return $this;
    }

    public function getAuthorName(): string
    {
        return (string) $this->_get(ChatMessagesInterface::AUTHOR_NAME);
    }

    public function setAuthorName(string $authorName): ChatMessagesInterface
    {
        $this->setData(self::AUTHOR_NAME, $authorName);
        return $this;
    }

    public function getMessage(): string
    {
        return (string) $this->_get(ChatMessagesInterface::MESSAGE);
    }

    public function setMessage(string $message): ChatMessagesInterface
    {
        $this->setData(ChatMessagesInterface::MESSAGE, $message);
        return $this;
    }

    public function getWebsiteId(): int
    {
        return (int) $this->_get(ChatMessagesInterface::WEBSITE_ID);
    }

    public function setWebsiteId(int $websiteId): ChatMessagesInterface
    {
        $this->setData(self::WEBSITE_ID, $websiteId);
        return $this;
    }

    public function getChatHash(): string
    {
        return (string) $this->_get(ChatMessagesInterface::CHAT_HASH);
    }

    public function setChatHash(string $chatHash): ChatMessagesInterface
    {
        $this->setData(self::CHAT_HASH, $chatHash);
        return $this;
    }

    public function getCreatedAt(): int
    {
        return (int) $this->_get(ChatMessagesInterface::CREATED_AT);
    }

    public function setCreatedAt(int $createdAt): ChatMessagesInterface
    {
        $this->setData(self::CREATED_AT, $createdAt);
        return $this;
    }
}
