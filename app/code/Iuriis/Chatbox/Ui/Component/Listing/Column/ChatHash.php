<?php
declare(strict_types=1);

namespace Iuriis\Chatbox\Ui\Component\Listing\Column;

use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;

class ChatHash extends \Magento\Ui\Component\Listing\Columns\Column
{
    /**
     * @var UrlInterface
     */
    protected $urlBuilder;

    /**
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        array $components = [],
        array $data = []
    ) {
        if ($context->getRequestParam('chat_hash')) {
            $data['config']['controlVisibility'] = false;
            $data['config']['visible'] = false;
        }

        parent::__construct($context, $uiComponentFactory, $components, $data);
    }
}
