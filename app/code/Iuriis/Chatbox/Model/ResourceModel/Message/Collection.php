<?php
declare(strict_types=1);

namespace Iuriis\Chatbox\Model\ResourceModel\Message;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'message_id';

    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        parent::_construct();
        $this->_init(
            \Iuriis\Chatbox\Model\Message::class,
            \Iuriis\Chatbox\Model\ResourceModel\Message::class
        );
    }

    /**
     * @param int $websiteId
     * @return $this
     */
    public function addWebsiteFilter(int $websiteId): self
    {
        return $this->addFieldToFilter('website_id', $websiteId);
    }

    /**
     * @param int $authorId
     * @return $this
     */
    public function addAuthorIdFilter(int $authorId): self
    {
        return $this->addFieldToFilter('author_id', $authorId);
    }

    /**
     * @param string $authorType
     * @return $this
     */
    public function addAuthorTypeFilter(string $authorType): self
    {
        return $this->addFieldToFilter('author_type', $authorType);
    }
}
