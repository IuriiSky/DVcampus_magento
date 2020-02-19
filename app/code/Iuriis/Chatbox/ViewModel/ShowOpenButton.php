<?php
declare(strict_types=1);

namespace Iuriis\Chatbox\ViewModel;

class ShowOpenButton implements \Magento\Framework\View\Element\Block\ArgumentInterface
{
    public const XML_PATH_ALLOW_FOR_GUESTS_GENERAL_ENABLED = 'iuriis_chat_box/general/allow_for_guests';
    public const XML_PATH_IURIIS_CHAT_BOX_GENERAL_ENABLED = 'iuriis_chat_box/general/enabled';

    /**
     * @var \Magento\Customer\Model\Session $customerSession
     */
    private $customerSession;
    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     */
    private $scopeConfig;
    /**
     * @var \Psr\Log\LoggerInterface $logger
     */
    private $logger;

    /**
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Psr\Log\LoggerInterface $logger
     */

    public function __construct(
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Psr\Log\LoggerInterface $logger
    ) {
        $this->customerSession = $customerSession;
        $this->logger = $logger;
        $this->scopeConfig = $scopeConfig;
    }

    /** @return bool */
    public function isGuestEnabled(): bool
    {
        $allowSendingMessages = true;

        if (!$this->scopeConfig->getValue(self::XML_PATH_IURIIS_CHAT_BOX_GENERAL_ENABLED)
            || (!$this->customerSession->isLoggedIn() && !$this->scopeConfig->getValue(self::XML_PATH_ALLOW_FOR_GUESTS_GENERAL_ENABLED))
        ) {
            $allowSendingMessages = false;
        }

        return $allowSendingMessages;
    }
}
