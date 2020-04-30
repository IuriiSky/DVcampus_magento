<?php
declare(strict_types=1);

namespace Iuriis\AskAboutThisProduct\Controller\Capcha;

class CaptchaFormPost extends \Magento\Framework\App\Action\Action
{
    /**
     * CaptchaFormPost constructor.
     * @param \Magento\Framework\App\Action\Context $context
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context
    ) {
        parent::__construct($context);
    }

    public function execute()
    {
        $this->messageManager->addSuccess(__('Success!'));
        $redirect = $this->resultRedirectFactory->create();
        $redirect->setUrl('/captchaForm');
        return $redirect;
    }
}
