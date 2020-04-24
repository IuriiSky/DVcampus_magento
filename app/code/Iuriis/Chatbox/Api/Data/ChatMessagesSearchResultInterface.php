<?php

declare(strict_types=1);

namespace Iuriis\Chatbox\Api\Data;

/**
 * Must redefine the interface methods for \Magento\Framework\Reflection\DataObjectProcessor::buildOutputDataArray()
 * Must not declare return types to keep the interface consistent with the parent interface
 */
interface ChatMessagesSearchResultInterface extends \Magento\Framework\Api\SearchResultsInterface
{
    /**
     * @return \Iuriis\Chatbox\Api\Data\ChatMessagesInterface[]
     */
    public function getItems();

    /**
     * Set items list.
     *
     * @param \Iuriis\Chatbox\Api\Data\ChatMessagesInterface[] $items
     * @return $this
     */
    public function setItems(array $items = null);
}