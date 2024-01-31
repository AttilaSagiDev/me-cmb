<?php
/**
 * Copyright © 2016 Magevolve Ltd. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Me\Cmb\Model\Cmb\Source;

use Magento\Framework\Data\OptionSourceInterface;
use Magento\Directory\Model\ResourceModel\Country\CollectionFactory;

class Country implements OptionSourceInterface
{
    /**
     * @var CollectionFactory
     */
    private $countryCollectionFactory;

    /**
     * @var array
     */
    private $options;

    /**
     * Country constructor
     *
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(CollectionFactory $collectionFactory)
    {
        $this->countryCollectionFactory = $collectionFactory;
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

        $options = $this->countryCollectionFactory->create()->toOptionArray();
        $this->options = $options;

        return $this->options;
    }
}
