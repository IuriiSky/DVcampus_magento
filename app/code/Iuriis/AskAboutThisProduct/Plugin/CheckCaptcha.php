<?php
declare(strict_types=1);

namespace Iuriis\AskAboutThisProduct\Plugin;

class CheckCaptcha
{
    /**
     * @var \Magento\Captcha\Helper\Data
     */
    private $helper;

    /**
     * @var \Magento\Framework\Session\SessionManagerInterface
     */
    private $sessionManager;

    /**
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    private $resultJsonFactory;

    /**
     * @var \Magento\Captcha\Observer\CaptchaStringResolver
     */
    private $captchaStringResolver;

    /**
     * CheckCaptcha constructor.
     * @param \Magento\Captcha\Helper\Data $helper
     * @param \Magento\Framework\Session\SessionManagerInterface $sessionManager
     * @param \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory
     * @param \Magento\Captcha\Observer\CaptchaStringResolver $captchaStringResolver
     */
    public function __construct(
        \Magento\Captcha\Helper\Data $helper,
        \Magento\Framework\Session\SessionManagerInterface $sessionManager,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
        \Magento\Captcha\Observer\CaptchaStringResolver $captchaStringResolver
    ) {
        $this->helper = $helper;
        $this->sessionManager = $sessionManager;
        $this->resultJsonFactory = $resultJsonFactory;
        $this->captchaStringResolver = $captchaStringResolver;
    }

    /**
     * @param \Iuriis\AskAboutThisProduct\Controller\Email\SendMailToAdmin $mailToAdmin
     * @param \Closure $proceed
     * @return \Magento\Framework\Controller\Result\Json
     */
    public function aroundExecute(
        \Iuriis\AskAboutThisProduct\Controller\Email\SendMailToAdmin $mailToAdmin,
        \Closure $proceed
    ) {
        $formId = 'ask_form';
        $captchaModel = $this->helper->getCaptcha($formId);
        $result = $this->resultJsonFactory->create();

        if (!$captchaModel->isCorrect($this->captchaStringResolver->resolve($mailToAdmin->getRequest(), $formId))) {
            $this->sessionManager->setCustomerFormData($mailToAdmin->getRequest()->getPostValue());

            $message = __('Incorrect CAPTCHA');
            $title = __('Error');

            $response = [
                'message' => $message,
                'title' => $title
            ];
            return $result->setData($response);
        }
        return $proceed();
    }
}
