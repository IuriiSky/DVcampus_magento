<?php
declare(strict_types=1);

namespace Iuriis\HomeworkGeekhub\Block;

class Data extends \Magento\Framework\View\Element\Html\Select
{
    /**
     * Set element's HTML ID
     *
     * @param string $elementId ID
     * @return $this
     */
    public function setId($elementId)
    {
        $this->setData('id', $elementId);
        return $this;
    }
}
