<?php
declare(strict_types=1);

namespace Iuriis\Chatbox\Ui\Component\Form;
use Iuriis\Chatbox\Model\ResourceModel\Message\Collection as MessageCollection;

class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    public const ADMIN_RESOURCE = 'Iuriis_Chatbox::listing';
    /**
     * @var \Iuriis\Chatbox\Model\ResourceModel\Message\CollectionFactory
     */
    private $messageCollectionFactory;

    /**
     * @var array
     */
    protected $loadedData;

    /**
     * Constructor
     *
     * @param $name
     * @param $primaryFieldName
     * @param $requestFieldName
     * @param \Iuriis\Chatbox\Model\ResourceModel\Message\CollectionFactory $messageCollectionFactory
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        \Iuriis\Chatbox\Model\ResourceModel\Message\CollectionFactory $messageCollectionFactory,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);

        $this->collection = $messageCollectionFactory->create();
    }

    /**
     * Get data
     *
     * @return array
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getData()
    {
        if (!isset($this->loadedData)) {
            $items = $this->collection->getItems();

            foreach ($items as $job) {
                $this->loadedData[$job->getId()] = $job->getData();
            }
        }

        return $this->loadedData;
    }
}
