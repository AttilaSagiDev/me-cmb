<?php
/**
 * Copyright © 2016 Magevolve Ltd. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Me\Cmb\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Context;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Exception\LocalizedException;

class Cmb extends AbstractDb
{
    /**
     * Store manager
     *
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * Construct
     *
     * @param Context $context
     * @param StoreManagerInterface $storeManager
     * @param string $connectionName
     */
    public function __construct(
        Context $context,
        StoreManagerInterface $storeManager,
        $connectionName = null
    ) {
        $this->storeManager = $storeManager;
        parent::__construct($context, $connectionName);
    }

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('me_cmb', 'cmb_id');
    }

    /**
     * Perform operations before object save
     *
     * @param AbstractModel $object
     * @return $this
     */
    protected function _beforeSave(AbstractModel $object)
    {
        if (!$object->getStoreId()) {
            $object->setStoreId($this->storeManager->getStore()->getId());
        }

        return $this;
    }
}
