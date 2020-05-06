<?php
declare(strict_types=1);

namespace Iuriis\AskAboutThisProduct\Block;

class GetSkuProduct extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \Magento\Catalog\Block\Product\View $view
     */
    public $view;

    /**
     * GetSkuProduct constructor.
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Catalog\Block\Product\View $view
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Catalog\Block\Product\View $view,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->view = $view;
    }

    /**
     * @return string
     */
    public function getSkuProduct(): string
    {
        return $this->view->getProduct()->getSku();
    }
}
