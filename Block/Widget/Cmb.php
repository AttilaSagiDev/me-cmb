<?php
/**
 * Copyright © 2016 Magevolve Ltd. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Me\Cmb\Block\Widget;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Widget\Block\BlockInterface;
use Magento\Framework\Data\Form\FormKey;
use Magento\Directory\Block\Data as DirectoryData;
use Me\Cmb\Helper\Data as Helper;
use Magento\Customer\Model\Session;

/**
 * Cmb widget
 */
class Cmb extends Template implements BlockInterface
{
    /**
     * Default title
     *
     * @var string
     */
    const DEFAULT_TITLE = 'Request a Callback';

    /**
     * Default subtitle
     *
     * @var string
     */
    const DEFAULT_SUBTITLE = 'Please submit the form and we will call you back.';

    /**
     * @var int
     */
    const DEFAULT_YEAR_RANGE = 2;

    /**
     * @var FormKey
     */
    private $formKey;

    /*
     * @var DirectoryData
     */
    private $directoryData;

    /**
     * @var Helper
     */
    private $helper;

    /**
     * @var Session
     */
    private $customerSession;

    /**
     * @param Context $context
     * @param FormKey $formKey
     * @param DirectoryData $directoryData
     * @param Helper $helper
     * @param Session $customerSession
     * @param array $data
     */
    public function __construct(
        Context $context,
        FormKey $formKey,
        DirectoryData $directoryData,
        Helper $helper,
        Session $customerSession,
        array $data = []
    ) {
        $this->formKey = $formKey;
        $this->directoryData = $directoryData;
        $this->helper = $helper;
        $this->customerSession = $customerSession;
        parent::__construct($context, $data);
    }

    /**
     * Get Key pieces for caching block content
     *
     * @return array
     */
    public function getCacheKeyInfo()
    {
        return [
            'ME_CMB_FORM',
            $this->_storeManager->getStore()->getId(),
            $this->_design->getDesignTheme()->getId(),
            'template' => $this->getTemplate()
        ];
    }

    /**
     * Retrieve form key
     *
     * @return string
     */
    public function getFormKey()
    {
        return $this->formKey->getFormKey();
    }

    /**
     * Get show title
     *
     * @return bool
     */
    public function getShowTitle()
    {
        if (!$this->hasData('show_title')) {
            $this->setData('show_title', false);
        }
        return (bool)$this->getData('show_title');
    }

    /**
     * Get block title
     *
     * @return string
     */
    public function getTitle()
    {
        if (!$this->hasData('title')) {
            $this->setData('title', self::DEFAULT_TITLE);
        }
        return $this->getData('title');
    }

    /**
     * Get show subtitle
     *
     * @return bool
     */
    public function getShowSubtitle()
    {
        if (!$this->hasData('show_subtitle')) {
            $this->setData('show_subtitle', false);
        }
        return (bool)$this->getData('show_subtitle');
    }

    /**
     * Get block subtitle
     *
     * @return string
     */
    public function getSubTitle()
    {
        if (!$this->hasData('subtitle')) {
            $this->setData('subtitle', self::DEFAULT_SUBTITLE);
        }
        return $this->getData('subtitle');
    }

    /**
     * Get customer name
     *
     * @return string
     */
    public function getCustomerName()
    {
        if ($this->customerSession->isLoggedIn()) {
            return $this->customerSession->getCustomer()->getName();
        }

        return '';
    }

    /**
     * Get customer telephone
     *
     * @return string
     */
    public function getCustomerPhone()
    {
        if ($this->customerSession->isLoggedIn()) {
            return $this->customerSession->getCustomer()->getDefaultBillingAddress()->getTelephone();
        }

        return '';
    }

    /**
     * Get show call date
     *
     * @return bool
     */
    public function getShowCallDate()
    {
        if (!$this->hasData('show_call_date')) {
            $this->setData('show_call_date', false);
        }
        return (bool)$this->getData('show_call_date');
    }

    /**
     * Get show predefined time
     *
     * @return bool
     */
    public function getShowPredefinedTimes()
    {
        if (!$this->hasData('show_predefined')) {
            $this->setData('show_predefined', false);
        }
        return (bool)$this->getData('show_predefined');
    }

    /**
     * Get show country
     *
     * @return bool
     */
    public function getShowCountry()
    {
        if (!$this->hasData('show_country')) {
            $this->setData('show_country', false);
        }
        return (bool)$this->getData('show_country');
    }

    /**
     * Get calendar icon
     *
     * @return string
     */
    public function getCalIcon()
    {
        $this->getViewFileUrl('Magento_Theme::calendar.png');
    }

    /**
     * Get if weekends enabled in calendar
     *
     * @return bool
     */
    public function getDisableWeekends()
    {
        if (!$this->hasData('disable_weekends')) {
            $this->setData('disable_weekends', false);
        }
        return (bool)$this->getData('disable_weekends');
    }

    /**
     * Returns format which will be applied for call date in javascript
     *
     * @return string
     */
    public function getDateFormat()
    {
        return $this->_localeDate->getDateFormat(\IntlDateFormatter::SHORT);
    }

    /**
     * Get years range for calendar
     *
     * @return string
     */
    public function getYearsRange()
    {
        if (!$this->hasData('max_year')) {
            $yearRange = date('Y') . ':' . date('Y', strtotime('+' . self::DEFAULT_YEAR_RANGE . ' year'));
            $this->setData('year_range', $yearRange);
        }
        return $this->getData('year_range');
    }

    /**
     * Get max date for calendar
     *
     * @return string
     */
    public function getMaxDate()
    {
        if (!$this->hasData('max_year')) {
            $this->setData('max_date', '+' . self::DEFAULT_YEAR_RANGE . 'y +0m +0w +0d');
        }
        return $this->getData('max_date');
    }

    /**
     * Get country select html
     *
     * @return string
     */
    public function getCountryHtmlSelect()
    {
        return $this->directoryData->getCountryHtmlSelect(null, 'cmb_country', 'cmb_country');
    }

    /**
     * Get predefined times for select
     *
     * @return array
     */
    public function getTimes()
    {
        $predefinedTimes = [];

        foreach ($this->helper->getPredefinedTimes() as $time) {
            $predefinedTimes[] = $time;
        }

        return $predefinedTimes;
    }

    /**
     * Get ajax url
     *
     * @return string
     */
    public function getAjaxUrl()
    {
        return $this->getUrl(
            'cmb/ajax/post'
        );
    }

    /**
     * Get honeypot html
     *
     * @return string
     */
    public function getHoneypotHtml()
    {
        $html = '';
        if ($this->getHelper()->isHoneypotEnabled()) {
            $html = '
            <input name ="cmb_protection" id ="cmb_protection" value ="" type ="text" />
            <script type = "text/javascript" >
            require(["jquery"], function ($) {
                $("#cmb_protection").hide();
            });
            </script >
            ';
        }

        return $html;
    }

    /**
     * Get extension helper
     *
     * @return Helper
     */
    public function getHelper()
    {
        return $this->helper;
    }
}
