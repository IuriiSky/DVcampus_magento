<?php
declare(strict_types=1);

namespace Iuriis\Chatbox\Ui\Component\Listing;

use Magento\Framework\View\Element\UiComponent\ContextInterface;

class Container extends \Magento\Ui\Component\Container
{
    public function __construct(ContextInterface $context, array $components = [], array $data = [])
    {
        parent::__construct($context, $components, $data);

        $this->_data['config']['update_url'] = $this->context->getUrl(
            'mui/index/render',
            ['chat_hash' => (string) $this->context->getRequestParam('chat_hash')]
        );
        $this->_data['config']['render_url'] = $this->context->getUrl(
            'mui/index/render',
            ['chat_hash' => (string) $this->context->getRequestParam('chat_hash')]
        );
    }
}
