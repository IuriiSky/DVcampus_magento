<?php

namespace Iuriis\Chatbox\Model;

use Magento\Framework\Exception\LocalizedException;

/**
 * @method string getAuthorType()
 * @method $this setAuthorType(string $authorType)
 * @method int getAuthorId()
 * @method $this setAuthorId(int $authorId)
 * @method string getAuthorName()
 * @method $this setAuthorName(string $authorName)
 * @method string getMessage()
 * @method $this setMessage(string $message)
 * @method int getWebsiteId()
 * @method $this setWebsiteId(int $websiteId)
 * @method string getChatHash()
 * @method $this setChatHash(string $chatHash)
 * @method int getCreatedAt()
 * @method $this setCreatedAt(int $createdAt)
 */
class Message extends \Magento\Framework\Model\AbstractModel
{
    public const AUTHOR_TYPE_CUSTOMER = 'customer';

    public const AUTHOR_TYPE_ADMIN = 'admin';

    /**
     * @inheritDoc
     */
    protected function _construct(): void
    {
        parent::_construct();
        $this->_init(\Iuriis\Chatbox\Model\ResourceModel\Message::class);
    }

    /**
     * @return $this
     * @throws LocalizedException
     */
    public function beforeSave(): self
    {
        parent::beforeSave();
        $this->validate();
        return $this;
    }

    /** @throws LocalizedException */
    public function validate(): void
    {
//        if (!$this->getAuthorId() && $this->getAuthorType() === self::AUTHOR_TYPE_ADMIN) {
//            throw new LocalizedException(__('Can\'t send message: is not set.', 'author_id'));
//        }

        if (!$this->getWebsiteId()) {
            throw new LocalizedException(__('Cant\'t send message: is not set:', 'website_id'));
        }

        if (!$this->getMessage()) {
            throw new LocalizedException(__('Cant\'t send message: is not set:', 'message'));
        }
    }
}
