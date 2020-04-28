<?php
declare(strict_types=1);

namespace Iuriis\AskAboutThisProduct\Block;

class GetSkuProduct extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \Magento\Customer\Model\Session $customerSession
     */
    public $customerSession;

    /**
     * @var \Magento\Catalog\Block\Product\View $view
     */
    public $view;

    /**
     * GetSkuProduct constructor.
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Catalog\Block\Product\View $view
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Catalog\Block\Product\View $view,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->customerSession = $customerSession;
        $this->view = $view;
    }

    /**
     * @return string
     */
    public function getCustomerName(): string
    {
        $name = '';

        if ($this->customerSession->isLoggedIn()) {
            $name = $this->customerSession->getCustomer()->getName();
        }

        return $name;
    }

    public function getCustomerEmail(): string
    {
        $email = '';

        if ($this->customerSession->isLoggedIn()) {
            $email = $this->customerSession->getCustomerData()->getEmail();
        }

        return $email;
    }

    /**
     * @return string
     */
    public function getSkuProduct(): string
    {
        return $this->view->getProduct()->getSku();
    }
}
