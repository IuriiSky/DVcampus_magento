<?php
declare(strict_types=1);

namespace Iuriis\Chatbox\Block\Frontend;

class GetAdminMessages extends \Magento\Framework\View\Element\Template
{
    /**
     * @return array|null
     */
    public function getAdminMessages(): ? array
    {
        return $this->getData();
    }
}
