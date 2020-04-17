<?php
declare(strict_types=1);

namespace Iuriis\Chatbox\Ui\Component\Form\DataProvider\Modifier;

class ChatHashField implements \Magento\Ui\DataProvider\Modifier\ModifierInterface
{

    /**
     * @var \Magento\Framework\App\RequestInterface $request
     */
    public $request;

    /**
     * ChatHashField constructor.
     * @param \Magento\Framework\App\RequestInterface $request
     */
    public function __construct(
        \Magento\Framework\App\RequestInterface $request
    ) {
        $this->request = $request;
    }

    /**
     * @param array $data
     * @return array
     */
    public function modifyData(array $data): array
    {
        return $data;
    }

    /**
     * @param array $meta
     * @return array
     */
    public function modifyMeta(array $meta): array
    {
        $itemId = $this->request->getParam('chat_hash');
        $meta['general']['children']['chat_hash'] = [
            'arguments' => [
                'data' => [
                    'config' => [
                        'value' => $itemId,
                    ]
                ]
            ]
        ];

        return $meta;
    }
}
