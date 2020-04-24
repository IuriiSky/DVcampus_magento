<?php
declare(strict_types=1);

namespace Iuriis\Chatbox\Ui\Component\Form;

use Iuriis\Chatbox\Model\ResourceModel\Message\CollectionFactory;
use Magento\Ui\DataProvider\Modifier\ModifierInterface;
use Magento\Ui\DataProvider\Modifier\PoolInterface;

class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /**
     * @var \Magento\Cron\Model\ResourceModel\Schedule\Collection $collection
     */
    public $collection;

    /**
     * @var array $loadedData
     */
    public $loadedData;

    /**
     * @var \Magento\Ui\DataProvider\Modifier\PoolInterface $pool
     */
    public $pool;

    /**
     * @var \Magento\Framework\App\RequestInterface $request
     */
    public $request;

    /**
     * @param \Magento\Framework\App\RequestInterface $request
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param PoolInterface $pool
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\App\RequestInterface $request,
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        PoolInterface $pool,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();
        $this->pool = $pool;
        $this->request = $request;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * @inheritdoc
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getData(): array
    {
        if (!isset($this->loadedData)) {
            $this->loadedData = [];
            $items = $this->collection->getItems();
            /** @var \Iuriis\Chatbox\Model\Message $item */
            foreach ($items as $item) {
                $this->loadedData[$item->getId()] = $item->getData();
            }
        }
        $data = $this->loadedData;

        /** @var ModifierInterface $modifier */
        foreach ($this->pool->getModifiersInstances() as $modifier) {
            $this->data = $modifier->modifyData($data);
        }

        return $data;
    }

    /**
     * @inheritdoc
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getMeta(): array
    {
        $itemId = $this->request->getParam('chat_hash');
        $meta = parent::getMeta();

        /** @var ModifierInterface $modifier */
        foreach ($this->pool->getModifiersInstances() as $modifier) {
            $meta = $modifier->modifyMeta($meta);
        }
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
