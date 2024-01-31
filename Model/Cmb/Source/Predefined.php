<?php
/**
 * Copyright © 2016 Magevolve Ltd. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Me\Cmb\Model\Cmb\Source;

use Magento\Framework\Data\OptionSourceInterface;
use Me\Cmb\Helper\Data as DataHelper;

class Predefined implements OptionSourceInterface
{
    /**
     * @var DataHelper
     */
    private $helper;

    /**
     * @var array
     */
    private $options;

    /**
     * Constructor
     *
     * @param DataHelper $helper
     */
    public function __construct(DataHelper $helper)
    {
        $this->helper = $helper;
    }

    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        if ($this->options !== null) {
            return $this->options;
        }

        $availableOptions = $this->helper->getPredefinedTimes();
        $options = [];
        if (!empty($availableOptions)) {
            foreach ($availableOptions as $value) {
                if ($value != '') {
                    $options[] = [
                        'label' => $value,
                        'value' => $value,
                    ];
                }
            }
        }
        if (!empty($options)) {
            array_unshift($options, ['value' => '', 'label' => ' ']);
        }
        $this->options = $options;

        return $this->options;
    }
}
