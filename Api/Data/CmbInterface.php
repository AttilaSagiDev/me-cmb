<?php
/**
 * Copyright © 2016 Magevolve Ltd. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Me\Cmb\Api\Data;

/**
 * Me Cmb interface.
 *
 * @api
 */
interface CmbInterface
{
    /**
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    const CMB_ID = 'cmb_id';
    const CMB_FULL_NAME = 'cmb_full_name';
    const CMB_TELEPHONE = 'cmb_telephone';
    const CMB_CALL_DATE = 'cmb_call_date';
    const CMB_PREDEFINED = 'cmb_predefined';
    const CMB_COUNTRY = 'cmb_country';
    const CMB_STATUS = 'cmb_status';
    const STORE_ID = 'store_id';
    const CMB_POSTED_AT = 'cmb_posted_at';

    /**
     * Get ID
     *
     * @return int|null
     */
    public function getId();

    /**
     * Get full name
     *
     * @return string
     */
    public function getCmbFullName();

    /**
     * Get telephone
     *
     * @return string|null
     */
    public function getCmbTelephone();

    /**
     * Get call date
     *
     * @return string|null
     */
    public function getCmbCallDate();

    /**
     * Get predefined times
     *
     * @return string|null
     */
    public function getCmbPredefined();

    /**
     * Get country
     *
     * @return string|null
     */
    public function getCmbCountry();

    /**
     * Get status
     *
     * @return int|null
     */
    public function getCmbStatus();

    /**
     * Get store id
     *
     * @return int|null
     */
    public function getStoreId();

    /**
     * Get posted at
     *
     * @return string|null
     */
    public function getCmbPostedAt();

    /**
     * Set ID
     *
     * @param int $id
     * @return CmbInterface
     */
    public function setId($id);

    /**
     * Set full name
     *
     * @param string $fullName
     * @return CmbInterface
     */
    public function setCmbFullName($fullName);

    /**
     * Set telephone
     *
     * @param string $telephone
     * @return CmbInterface
     */
    public function setCmbTelephone($telephone);

    /**
     * Set call date
     *
     * @param string $callDate
     * @return CmbInterface
     */
    public function setCmbCallDate($callDate);

    /**
     * Set predefined time
     *
     * @param string $predefined
     * @return CmbInterface
     */
    public function setCmbPredefined($predefined);

    /**
     * Set country
     *
     * @param string $country
     * @return CmbInterface
     */
    public function setCmbCountry($country);

    /**
     * Set status
     *
     * @param int $status
     * @return CmbInterface
     */
    public function setCmbStatus($status);

    /**
     * Set store id
     *
     * @param int $storeId
     * @return CmbInterface
     */
    public function setStoreId($storeId);

    /**
     * Set posted at
     *
     * @param string $postedAt
     * @return CmbInterface
     */
    public function setCmbPostedAt($postedAt);
}
