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
    /**;

    /**
     * Email constructor.
     * @param \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder
     * @param \Magento\Framework\Translate\Inline\StateInterface $inlineTranslation
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     */
    public function __construct(
        \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder,
        \Magento\Framework\Translate\Inline\StateInterface $inlineTranslation,
        \Magento\Store\Model\StoreManagerInterface $storeManager
    ) {
        $this->transportBuilder = $transportBuilder;
        $this->inlineTranslation = $inlineTranslation;
        $this->storeManager = $storeManager;
    }

    public function send(): void
    {
        $templateVariables = [
            'name' => 'Dv Campus',
            'email' => 'email@example.com'
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
                ->setFromByScope('support') //getConfig work with config
                ->addTo('recipient@example.com') // добавити отримувача
                ->setReplyTo('uzik.fk11@gmail.com', 'Iurii Stepanenko')
                ->getTransport();

            $transport->sendMessage();
        } finally {
            $this->inlineTranslation->resume();
        }
    }
}
