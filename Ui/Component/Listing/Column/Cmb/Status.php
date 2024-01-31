<?php
/**
 * Copyright © 2016 Magevolve Ltd. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Me\Cmb\Ui\Component\Listing\Column\Cmb;

use Magento\Ui\Component\Listing\Columns\Column;
use Me\Cmb\Model\Cmb;

/**
 * Class Status
 */
class Status extends Column
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
        $class = '';
        $text = '';

        switch ($item['cmb_status']) {
            case Cmb::STATUS_NEW:
                $class = 'grid-severity-minor';
                $text = __('New');
                break;
            case Cmb::STATUS_PENDING:
                $class = 'grid-severity-major';
                $text = __('Pending');
                break;
            case Cmb::STATUS_DONE:
                $class = 'grid-severity-notice';
                $text = __('Done');
                break;
            default:
                $class = 'grid-severity-major';
                $text = __('Unknown');
                break;
        }

        return '<span class="' . $class . '"><span>' . $text . '</span></span>';
    }
}
