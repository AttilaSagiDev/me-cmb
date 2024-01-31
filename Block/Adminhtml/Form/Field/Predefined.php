<?php
/**
 * Copyright © 2015 Magevolve Ltd.
 * See COPYING.txt for license details.
 */
namespace Me\Cmb\Block\Adminhtml\Form\Field;

use Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;

class Predefined extends AbstractFieldArray
{
    /**
     * Prepare to render
     *
     * @return void
     */
    protected function _prepareToRender()
    {
        $this->addColumn(
            'predefined',
            [
                'label' => __('Predefined Interval'),
                'class' => 'required-entry'
            ]
        );
        $this->_addAfter = true;
        $this->_addButtonLabel = __('Add More');
    }
}
