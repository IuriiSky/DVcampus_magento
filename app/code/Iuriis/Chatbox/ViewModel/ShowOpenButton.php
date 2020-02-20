<?php
declare(strict_types=1);

namespace Iuriis\Chatbox\ViewModel;

use Magento\Store\Model\ScopeInterface;

class ShowOpenButton implements \Magento\Framework\View\Element\Block\ArgumentInterface
{
    public const XML_PATH_ALLOW_FOR_GUESTS_GENERAL_ENABLED = 'iuriis_chat_box/general/allow_for_guests';

    /**
     * @var \Magento\Customer\Model\Session $customerSession
     */
    private $customerSession;

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     */
    private $scopeConfig;

    /**
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    ) {
        $this->customerSession = $customerSession;
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * @return bool
     */
    public function isGuestEnabled(): bool
    {
        $allowSendingMessages = true;

        if ((!$this->customerSession->isLoggedIn() && !$this->customerSession->getCustomerGroupId())
            && !$this->scopeConfig->getValue(
                self::XML_PATH_ALLOW_FOR_GUESTS_GENERAL_ENABLED,
                ScopeInterface::SCOPE_STORE
            )
        ) {
            $allowSendingMessages = false;
        }

        return $allowSendingMessages;
    }
}
