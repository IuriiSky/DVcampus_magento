<?php

namespace Iuriis\Chatbox\Model;

use Magento\Framework\Exception\LocalizedException;

/**
 * @method int getAuthorId()
 * @method $this setAuthorId(int $authorId)
 * @method int getWebsiteId()
 * @method $this setWebsiteId(int $websiteId)
 * @method string getMessage()
 * @method $this setMessage(string $message)
 * @method int getCreatedAt()
 * @method $this setCreatedAt(int $createdAt)
 */
class Message extends \Magento\Framework\Model\AbstractModel
{
    /**
     * Message constructor
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Model\ResourceModel\AbstractResource $resource
     * @param \Magento\Framework\Data\Collection\AbstractDb $resourceCollection
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

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
        if (!$this->getAuthorId()) {
            throw new LocalizedException(__('Can\'t send message: is not set.', 'customer_id'));
        }

        if (!$this->getWebsiteId()) {
            throw new LocalizedException(__('Cant\'t send message: is not set:', 'website_id'));
        }
    }
}
