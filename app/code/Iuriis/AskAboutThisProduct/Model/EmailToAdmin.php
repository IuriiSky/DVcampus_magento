<?php
declare(strict_types=1);

namespace Iuriis\AskAboutThisProduct\Model;

use Magento\Framework\App\Area;

class EmailToAdmin
{
    /**
     * @var \Magento\Framework\Mail\Template\TransportBuilder
     */
    private $transportBuilder;

    /**
     * @var \Magento\Framework\Translate\Inline\StateInterface
     */
    private $inlineTranslation;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var \Magento\Framework\App\Action\Action
     */
    private $request;

    /**
     * Email constructor.
     * @param \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder
     * @param \Magento\Framework\Translate\Inline\StateInterface $inlineTranslation
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Framework\App\Action\Action $request
     */
    public function __construct(
        \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder,
        \Magento\Framework\Translate\Inline\StateInterface $inlineTranslation,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\App\Action\Action $request
    ) {
        $this->transportBuilder = $transportBuilder;
        $this->inlineTranslation = $inlineTranslation;
        $this->storeManager = $storeManager;
        $this->request = $request;
    }

    public function send(): void
    {
        $requestData = $this->request->getRequest()->getPostValue();

        $customerName = $requestData['name'];
        $customerEmail = $requestData['email'];
        $sku = $requestData['sku'];
        $customerQuestion = $requestData['question'];

        $templateVariables = [
            'name' => $customerName,
            'email' => $customerEmail,
            'sku' => $sku,
            'question' => $customerQuestion,
        ];

        $this->inlineTranslation->suspend();

        try {
            $transport = $this->transportBuilder
                ->setTemplateIdentifier('iuriis_ask_about_this_product')
                ->setTemplateOptions(
                    [
                        'area' => Area::AREA_FRONTEND,
                        'store' => $this->storeManager->getStore()->getId()
                    ]
                )
                ->setTemplateVars($templateVariables)
                ->setFromByScope('support')
                ->addTo('support@example.com')
                ->setReplyTo('support@example.com', 'Administrator')
                ->getTransport();

            $transport->sendMessage();
        } finally {
            $this->inlineTranslation->resume();
        }
    }
}
