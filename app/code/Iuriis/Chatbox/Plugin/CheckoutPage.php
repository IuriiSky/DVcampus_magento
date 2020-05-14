<?php
declare(strict_types=1);

namespace Iuriis\Chatbox\Plugin;

use Iuriis\Chatbox\Model\Message;

class CheckoutPage
{
    /**
     * @var \Iuriis\Chatbox\Model\ResourceModel\Message\CollectionFactory $messageCollectionFactory
     */
    private $messageCollectionFactory;

    /**
     * @var \Magento\Framework\App\Request\Http
     */
    private $request;
    /**
     * @var \Magento\Framework\UrlInterface
     */
    private $urlManager;
    /**
     * @var \Iuriis\Chatbox\Model\ResourceModel\Message
     */
    private $messageResource;

    /**
     * @param \Iuriis\Chatbox\Model\ResourceModel\Message\CollectionFactory $messageCollectionFactory
     * @param \Iuriis\Chatbox\Model\ResourceModel\Message $messageResource
     * @param \Magento\Framework\App\Request\Http $request
     * @param \Magento\Framework\UrlInterface $urlManager
     */

    public function __construct(
        \Iuriis\Chatbox\Model\ResourceModel\Message\CollectionFactory $messageCollectionFactory,
        \Iuriis\Chatbox\Model\ResourceModel\Message $messageResource,
        \Magento\Framework\App\Request\Http $request,
        \Magento\Framework\UrlInterface $urlManager
    ) {
        $this->messageCollectionFactory = $messageCollectionFactory;
        $this->request = $request;
        $this->urlManager = $urlManager;
        $this->messageResource = $messageResource;
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function beforeExecute($subject)
    {

        $baseUrl = $this->urlManager->getCurrentUrl();

        if ($baseUrl === 'checkout') {
            $messagePriority = Message::MESSAGE_PRIORITY_IMMEDIATE;
        } else {
            $messagePriority = Message::MESSAGE_PRIORITY_REGULAR;
        }

        return $messagePriority;
    }
}
