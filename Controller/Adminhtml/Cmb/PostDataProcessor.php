<?php
/**
 * Copyright © 2016 Magevolve Ltd. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Me\Cmb\Controller\Adminhtml\Cmb;

use Magento\Framework\Stdlib\DateTime\Filter\Date;
use Magento\Framework\View\Model\Layout\Update\ValidatorFactory;
use Magento\Framework\Message\ManagerInterface;

class PostDataProcessor
{
    /**
     * @var Date
     */
    private $dateFilter;

    /**
     * @var ValidatorFactory
     */
    private $validatorFactory;

    /**
     * @var ManagerInterface
     */
    private $messageManager;

    /**
     * @param Date $dateFilter
     * @param ManagerInterface $messageManager
     * @param ValidatorFactory $validatorFactory
     */
    public function __construct(
        Date $dateFilter,
        ManagerInterface $messageManager,
        ValidatorFactory $validatorFactory
    ) {
        $this->dateFilter = $dateFilter;
        $this->messageManager = $messageManager;
        $this->validatorFactory = $validatorFactory;
    }

    /**
     * Filtering posted data. Converting localized data if needed
     *
     * @param array $data
     * @return array
     */
    public function filter($data)
    {
        $filterRules = [];

        foreach (['cmb_call_date'] as $dateField) {
            if (!empty($data[$dateField])) {
                $filterRules[$dateField] = $this->dateFilter;
            }
        }

        return (new \Zend_Filter_Input($filterRules, [], $data))->getUnescaped();
    }

    /**
     * Check if required fields is not empty
     *
     * @param array $data
     * @return bool
     */
    public function validateRequireEntry(array $data)
    {
        $requiredFields = [
            'cmb_full_name' => __('Full Name'),
            'cmb_telephone' => __('Telephone'),
            'cmb_status' => __('Status')
        ];
        $errorNo = true;
        foreach ($data as $field => $value) {
            if (in_array($field, array_keys($requiredFields)) && $value == '') {
                $errorNo = false;
                $this->messageManager->addErrorMessage(
                    __('To apply changes you should fill in hidden required "%1" field', $requiredFields[$field])
                );
            }
        }
        return $errorNo;
    }
}
