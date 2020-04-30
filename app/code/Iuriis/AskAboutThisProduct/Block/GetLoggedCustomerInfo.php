<?php
declare(strict_types=1);

namespace Iuriis\AskAboutThisProduct\Block;

class GetLoggedCustomerInfo extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \Magento\Customer\Model\Session $customerSession
     */
    public $customerSession;

    /**
     * GetSkuProduct constructor.
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Customer\Model\Session $customerSession
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Customer\Model\Session $customerSession,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->customerSession = $customerSession;
    }

    /**
     * @return string
     */
    public function getCustomerName(): string
    {
        if ($this->customerSession->isLoggedIn()) {
            $name = $this->customerSession->getCustomer()->getName();
        } else {
            $name = '';
        }

        return $name;
    }

    public function getCustomerEmail(): string
    {
        if ($this->customerSession->isLoggedIn()) {
            $email = $this->customerSession->getCustomerData()->getEmail();
        } else {
            $email = '';
        }
        return $email;
    }
}
