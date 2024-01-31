<?php
/**
 * Copyright © 2016 Magevolve Ltd. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Me\Cmb\Model\Cmb\Source;

use Magento\Framework\Data\OptionSourceInterface;
use Me\Cmb\Model\Cmb;

class Status implements OptionSourceInterface
{
    /**
     * @var Cmb
     */
    private $cmbItem;

    /**
     * Constructor
     *
     * @param Cmb $cmbItem
     */
    public function __construct(Cmb $cmbItem)
    {
        $this->cmbItem = $cmbItem;
    }

    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        $availableOptions = $this->cmbItem->getAvailableStatuses();
        $options = [];
        foreach ($availableOptions as $key => $value) {
            $options[] = [
                'label' => $value,
                'value' => $key,
            ];
        }
        return $options;
    }
}
