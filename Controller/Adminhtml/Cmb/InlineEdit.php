<?php
/**
 * Copyright © 2016 Magevolve Ltd. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Me\Cmb\Controller\Adminhtml\Cmb;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Me\Cmb\Api\CmbRepositoryInterface as CmbRepository;
use Magento\Framework\Controller\Result\JsonFactory;
use Me\Cmb\Api\Data\CmbInterface;
use Magento\Framework\Exception\LocalizedException;
use Me\Cmb\Model\Cmb;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Controller\Result\Json;

/**
 * Cmb item grid inline edit controller
 */
class InlineEdit extends Action
{
    /**
     * @var PostDataProcessor
     */
    private $dataProcessor;

    /**
     * @var CmbRepository
     */
    private $cmbRepository;

    /**
     * @var JsonFactory
     */
    private $jsonFactory;

    /**
     * @param Context $context
     * @param PostDataProcessor $dataProcessor
     * @param CmbRepository $cmbRepository
     * @param JsonFactory $jsonFactory
     */
    public function __construct(
        Context $context,
        PostDataProcessor $dataProcessor,
        CmbRepository $cmbRepository,
        JsonFactory $jsonFactory
    ) {
        parent::__construct($context);
        $this->dataProcessor = $dataProcessor;
        $this->cmbRepository = $cmbRepository;
        $this->jsonFactory = $jsonFactory;
    }

    /**
     * @return $this|\Magento\Framework\App\ResponseInterface|ResultInterface
     * @throws LocalizedException
     */
    public function execute()
    {
        /** @var Json $resultJson */
        $resultJson = $this->jsonFactory->create();
        $error = false;
        $messages = [];

        $postItems = $this->getRequest()->getParam('items', []);
        if (!($this->getRequest()->getParam('isAjax') && !empty($postItems))) {
            return $resultJson->setData([
                'messages' => [__('Please correct the data sent.')],
                'error' => true,
            ]);
        }

        foreach (array_keys($postItems) as $cmbId) {
            /** @var Cmb $cmb */
            $cmb = $this->cmbRepository->getById($cmbId);
            try {
                $cmbData = $this->filterPost($postItems[$cmbId]);
                $this->validatePost($cmbData, $cmb, $error, $messages);
                $extendedCmbData = $cmb->getData();
                $this->setCmbData($cmb, $extendedCmbData, $cmbData);
                $this->saveCmb($cmb);
            } catch (\RuntimeException $e) {
                $messages[] = $this->getErrorWithCmbId($cmb, $e->getMessage());
                $error = true;
            } catch (\Exception $e) {
                $messages[] = $this->getErrorWithCmbId(
                    $cmb,
                    __('Something went wrong while saving the item.')
                );
                $error = true;
            }
        }

        return $resultJson->setData([
            'messages' => $messages,
            'error' => $error
        ]);
    }

    /**
     * Save Cmb item
     *
     * @param CmbInterface $cmb
     * @throws LocalizedException
     */
    private function saveCmb(CmbInterface $cmb)
    {
        $this->cmbRepository->save($cmb);
    }

    /**
     * Filtering posted data.
     *
     * @param array $postData
     * @return array
     */
    private function filterPost($postData = [])
    {
        $cmbData = $this->dataProcessor->filter($postData);
        $cmbData['cmb_predefined'] = isset($cmbData['cmb_predefined']) ? $cmbData['cmb_predefined'] : null;
        $cmbData['cmb_country'] = isset($cmbData['cmb_country']) ? $cmbData['cmb_country'] : null;
        return $cmbData;
    }

    /**
     * Validate post data
     *
     * @param array $cmbData
     * @param Cmb $cmb
     * @param bool $error
     * @param array $messages
     * @return void
     */
    private function validatePost(array $cmbData, Cmb $cmb, &$error, array &$messages)
    {
        if (!($this->dataProcessor->validateRequireEntry($cmbData))) {
            $error = true;
            foreach ($this->messageManager->getMessages(true)->getItems() as $error) {
                $messages[] = $this->getErrorWithCmbId($cmb, $error->getText());
            }
        }
    }

    /**
     * Add page title to error message
     *
     * @param CmbInterface $cmb
     * @param string $errorText
     * @return string
     */
    private function getErrorWithCmbId(CmbInterface $cmb, $errorText)
    {
        return '[CMB ID: ' . $cmb->getId() . '] ' . $errorText;
    }

    /**
     * Set Cmb item data
     *
     * @param Cmb $cmb
     * @param array $extendedCmbData
     * @param array $cmbData
     * @return $this
     */
    private function setCmbData(Cmb $cmb, array $extendedCmbData, array $cmbData)
    {
        $cmb->setData(array_merge($cmb->getData(), $extendedCmbData, $cmbData));
        return $this;
    }
}
