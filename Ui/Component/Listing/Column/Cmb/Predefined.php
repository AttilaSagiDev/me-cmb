<?php
/**
 * Copyright © 2016 Magevolve Ltd. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Me\Cmb\Ui\Component\Listing\Column\Cmb;

use Magento\Ui\Component\Listing\Columns\Column;

/**
 * Class Predefined
 */
class Predefined extends Column
{
    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                $item[$this->getData('name')] = $this->prepareItem($item);
            }
        }

        return $dataSource;
    }

    /**
     * Get data
     *
     * @param array $item
     * @return string
     */
    private function prepareItem(array $item)
    {
        switch ($item['cmb_predefined']) {
            case null:
                $text = __('N/A');
                break;
            case '':
                $text = __('N/A');
                break;
            default:
                $text = $item['cmb_predefined'];
                break;
        }

        return $text;
    }
}
