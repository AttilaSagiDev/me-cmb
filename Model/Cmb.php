<?php
/**
 * Copyright © 2016 Magevolve Ltd. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Me\Cmb\Model;

use Me\Cmb\Api\Data\CmbInterface;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;

class Cmb extends AbstractModel implements CmbInterface, IdentityInterface
{
    /**
     * Cmb statuses
     */
    const STATUS_NEW = 0;
    const STATUS_PENDING = 1;
    const STATUS_DONE = 2;

    /**
     * Me Cmb cache tag
     */
    const CACHE_TAG = 'me_cmb';

    /**
     * @var string
     */
    protected $_cacheTag = 'me_cmb';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'me_cmb';

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Me\Cmb\Model\ResourceModel\Cmb');
    }

    /**
     * Get ID
     *
     * @return int|null
     */
    public function getId()
    {
        return $this->getData(self::CMB_ID);
    }

    /**
     * Get full name
     *
     * @return string
     */
    public function getCmbFullName()
    {
        return $this->getData(self::CMB_FULL_NAME);
    }

    /**
     * Get telephone
     *
     * @return string|null
     */
    public function getCmbTelephone()
    {
        return $this->getData(self::CMB_TELEPHONE);
    }

    /**
     * Get call date
     *
     * @return string|null
     */
    public function getCmbCallDate()
    {
        return $this->getData(self::CMB_CALL_DATE);
    }

    /**
     * Get predefined times
     *
     * @return string|null
     */
    public function getCmbPredefined()
    {
        return $this->getData(self::CMB_PREDEFINED);
    }

    /**
     * Get country
     *
     * @return string|null
     */
    public function getCmbCountry()
    {
        return $this->getData(self::CMB_COUNTRY);
    }

    /**
     * Get status
     *
     * @return int|null
     */
    public function getCmbStatus()
    {
        return (int)$this->getData(self::CMB_STATUS);
    }

    /**
     * Get store id
     *
     * @return int|null
     */
    public function getStoreId()
    {
        return (int)$this->getData(self::STORE_ID);
    }

    /**
     * Get posted at
     *
     * @return string|null
     */
    public function getCmbPostedAt()
    {
        return $this->getData(self::CMB_POSTED_AT);
    }

    /**
     * Set ID
     *
     * @param int $id
     * @return CmbInterface
     */
    public function setId($id)
    {
        return $this->setData(self::CMB_ID, $id);
    }

    /**
     * Set full name
     *
     * @param string $fullName
     * @return CmbInterface
     */
    public function setCmbFullName($fullName)
    {
        return $this->setData(self::CMB_FULL_NAME, $fullName);
    }

    /**
     * Set telephone
     *
     * @param string $telephone
     * @return CmbInterface
     */
    public function setCmbTelephone($telephone)
    {
        return $this->setData(self::CMB_TELEPHONE, $telephone);
    }

    /**
     * Set call date
     *
     * @param string $callDate
     * @return CmbInterface
     */
    public function setCmbCallDate($callDate)
    {
        return $this->setData(self::CMB_CALL_DATE, $callDate);
    }

    /**
     * Set predefined time
     *
     * @param string $predefined
     * @return CmbInterface
     */
    public function setCmbPredefined($predefined)
    {
        return $this->setData(self::CMB_PREDEFINED, $predefined);
    }

    /**
     * Set country
     *
     * @param string $country
     * @return CmbInterface
     */
    public function setCmbCountry($country)
    {
        return $this->setData(self::CMB_COUNTRY, $country);
    }

    /**
     * Set status
     *
     * @param int $status
     * @return CmbInterface
     */
    public function setCmbStatus($status)
    {
        return $this->setData(self::CMB_STATUS, $status);
    }

    /**
     * Set store id
     *
     * @param int $storeId
     * @return CmbInterface
     */
    public function setStoreId($storeId)
    {
        return $this->setData(self::STORE_ID, $storeId);
    }

    /**
     * Set posted at
     *
     * @param string $postedAt
     * @return CmbInterface
     */
    public function setCmbPostedAt($postedAt)
    {
        return $this->setData(self::CMB_POSTED_AT, $postedAt);
    }

    /**
     * Get identities
     *
     * @return array
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId(), self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * Receive cmb store ids
     *
     * @return int[]
     */
    public function getStores()
    {
        return $this->hasData('stores') ? $this->getData('stores') : $this->getData('store_id');
    }

    /**
     * Prepare cmb statuses
     *
     * @return array
     */
    public function getAvailableStatuses()
    {
        return [
            self::STATUS_NEW => __('New'),
            self::STATUS_PENDING => __('Pending'),
            self::STATUS_DONE => __('Done')
        ];
    }
}
