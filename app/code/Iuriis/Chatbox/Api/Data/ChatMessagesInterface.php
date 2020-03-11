<?php

declare(strict_types=1);

namespace Iuriis\Chatbox\Api\Data;

interface ChatMessagesInterface
{
    public const MESSAGE_ID = 'message_id';

    public const AUTHOR_TYPE = 'author_type';

    public const AUTHOR_ID = 'author_id';

    public const AUTHOR_NAME = 'author_name';

    public const MESSAGE = 'message';

    public const WEBSITE_ID = 'website_id';

    public const CHAT_HASH = 'chat_hash';

    public const CREATED_AT = 'created_at';

    /**
     * @return string
     */
    public function getAuthorType(): string;

    /**
     * @param string $authorType
     * @return $this
     */
    public function setAuthorType(string $authorType): self;

    /**
     * @return int
     */
    public function getAuthorId(): int;

    /**
     * @param int $authorId
     * @return $this
     */
    public function setAuthorId(int $authorId): self;

    /**
     * @return string
     */
    public function getAuthorName(): string;

    /**
     * @param string $authorName
     * @return $this
     */
    public function setAuthorName(string $authorName): self;

    /**
     * @return string
     */
    public function getMessage(): string;

    /**
     * @param string $message
     * @return $this
     */
    public function setMessage(string $message): self;

    /**
     * @return int
     */
    public function getWebsiteId(): int;

    /**
     * @param int $websiteId
     * @return $this
     */
    public function setWebsiteId(int $websiteId): self;

    /**
     * @return string
     */
    public function getChatHash(): string;

    /**
     * @param string $chatHash
     * @return $this
     */
    public function setChatHash(string $chatHash): self;

    /**
     * @return int
     */
    public function getCreatedAt(): int;

    /**
     * @param int $createdAt
     * @return $this
     */
    public function setCreatedAt(int $createdAt): self;
}