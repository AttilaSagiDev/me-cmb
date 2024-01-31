<?php
/**
 * Copyright © 2016 Magevolve Ltd. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Me\Cmb\Controller\Ajax;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Me\Cmb\Helper\Data as DataHelper;
use Magento\Framework\Data\Form\FormKey\Validator;
use Magento\Framework\Controller\Result\JsonFactory;
use Me\Cmb\Model\Cmb;
use Magento\Framework\Escaper;
use Magento\Framework\Exception\LocalizedException;

class Post extends Action
{
    /**
     * @var DataHelper
     */
    private $dataHelper;

    /**
     * @var Validator
     */
    private $formKeyValidator;

    /**
     * @var JsonFactory
     */
    private $resultJsonFactory;

    /**
     * @var Cmb
     */
    private $cmbFactory;

    /**
     * @var Escaper
     */
    private $escaper;

    /**
     * @param Context $context
     * @param Validator $formKeyValidator
     * @param JsonFactory $resultJsonFactory
     * @param Cmb $cmbFactory
     * @param Escaper $escaper
     * @param DataHelper $dataHelper
     */
    public function __construct(
        Context $context,
        Validator $formKeyValidator,
        JsonFactory $resultJsonFactory,
        Cmb $cmbFactory,
        Escaper $escaper,
        DataHelper $dataHelper
    ) {
        parent::__construct($context);
        $this->formKeyValidator = $formKeyValidator;
        $this->resultJsonFactory = $resultJsonFactory;
        $this->cmbFactory = $cmbFactory;
        $this->escaper = $escaper;
        $this->dataHelper = $dataHelper;
    }

    /**
     * Post action
     *
     * @return $this|\Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $response = [
            'success' => false,
            'content' => ''
        ];

        $post = $this->getRequest()->getPostValue();
        if ($post) {
            try {
                if (!$this->dataHelper->isEnabled()) {
                    throw new LocalizedException(__('Extension disabled. The page will reload automatically.'));
                }

                if (!$this->formKeyValidator->validate($this->getRequest())) {
                    throw new LocalizedException(__('Invalid form key. The page will reload automatically.'));
                }

                if ($this->dataHelper->isHoneypotEnabled()
                    && isset($post['cmb_protection'])
                    && $post['cmb_protection'] != ''
                ) {
                    throw new LocalizedException(
                        __('SPAM detection on form submit! The page will reload automatically.')
                    );
                }

                $cmb = $this->cmbFactory->addData($post);
                $cmb->save();
                $this->_eventManager->dispatch(
                    'send_cmb_notification',
                    ['cmb' => $cmb]
                );
                $response['success'] = true;
                $response['content'] = $this->dataHelper->getSuccessMessage();
            } catch (LocalizedException $e) {
                $response['content'] = $this->escaper->escapeHtml($e->getMessage());
            } catch (\Exception $e) {
                $response['content'] = __('We can\'t save the request');
            }
        } else {
            $response['content'] = __('Empty form values');
        }

        $resultJson = $this->resultJsonFactory->create();
        return $resultJson->setData($response);
    }
}
