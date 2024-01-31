<?php
/**
 * Copyright © 2016 Magevolve Ltd. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Me\Cmb\Model\System\Config\Backend;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\App\Config\Value as ConfigValue;

class Check extends ConfigValue
{
    /**
     * Processing object before save data
     *
     * @return $this
     * @throws \Exception
     */
    public function beforeSave()
    {
        $enabled = (bool)$this->getValue();
        $predefined = $this->getData('groups/date/fields/predefined_times/value');
        unset($predefined['__empty']);

        if ($enabled) {
            try {
                if (empty($predefined)) {
                    throw new LocalizedException(
                        __('Please add predefined times!')
                    );
                }
            } catch (\Exception $e) {
                throw new LocalizedException(__($e->getMessage()), $e);
            }
        }
        return $this;
    }
}
