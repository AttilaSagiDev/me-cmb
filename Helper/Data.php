<?php
/**
 * Copyright © 2016 Magevolve Ltd. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Me\Cmb\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\ScopeInterface;
use Magento\Framework\Serialize\Serializer\Json;

class Data extends AbstractHelper
{
    /**
     * Store config is extension enabled
     */
    const XML_PATH_ENABLED = 'cmb/basic/active';

    /**
     * Store config show predefined times
     */
    const XML_PATH_SHOW_PREDEFINED = 'cmb/date/show_predefined';

    /**
     * Store config predefined times
     */
    const XML_PATH_PREDEFINED_TIME = 'cmb/date/predefined_times';

    /**
     * Store config success message
     */
    const XML_PATH_SUCCESS = 'cmb/messages/success_message';

    /**
     * Store config success message delay
     */
    const XML_PATH_SUCCESS_DELAY = 'cmb/messages/success_delay';

    /**
     * Store config email notification enabled
     */
    const XML_PATH_EMAIL_ENABLED = 'cmb/email/email_enable';

    /**
     * Store config email recipient
     */
    const XML_PATH_EMAIL_RECIPIENT = 'cmb/email/recipient_email';

    /**
     * Store config email sender identity
     */
    const XML_PATH_EMAIL_SENDER = 'cmb/email/sender_email_identity';

    /**
     * Store config email template
     */
    const XML_PATH_EMAIL_TEMPLATE = 'cmb/email/email_template';

    /**
     * Store config email template
     */
    const XML_PATH_HONEYPOT = 'cmb/honeypot/honeypot_enable';

    /**
     * @var Json
     */
    private $serialize;

    /**
     * @param Context $context
     * @param Json $serialize
     */
    public function __construct(
        Context $context,
        Json $serialize
    ) {
        $this->serialize = $serialize;
        parent::__construct($context);
    }

    /**
     * Check if enabled
     *
     * @return bool
     */
    public function isEnabled()
    {
        return $this->scopeConfig->isSetFlag(
            self::XML_PATH_ENABLED,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Get success message
     *
     * @return string
     */
    public function getSuccessMessage()
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_SUCCESS,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Get success delay
     *
     * @return int
     */
    public function getSuccessDelay()
    {
        $successDelay = (int)$this->scopeConfig->getValue(
            self::XML_PATH_SUCCESS_DELAY,
            ScopeInterface::SCOPE_STORE
        );

        if (!$successDelay) {
            $successDelay = 5;
        }

        return $successDelay * 1000;
    }

    /**
     * Check if show predefined times
     *
     * @return bool
     */
    public function getShowPredefined()
    {
        return $this->scopeConfig->isSetFlag(
            self::XML_PATH_SHOW_PREDEFINED,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Get predefined times
     *
     * @return array
     */
    public function getPredefinedTimes()
    {
        $result = [];

        $value = $this->scopeConfig->getValue(
            self::XML_PATH_PREDEFINED_TIME,
            ScopeInterface::SCOPE_STORE
        );

        if (is_string($value) && !empty($value)) {
            $result = $this->serialize->unserialize($value);
        }

        return $result;
    }

    /**
     * Check if email notification enabled
     *
     * @return bool
     */
    public function isEmailEnabled()
    {
        return $this->scopeConfig->isSetFlag(
            self::XML_PATH_EMAIL_ENABLED,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Get email recipient
     *
     * @return string
     */
    public function getEmailRecipient()
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_EMAIL_RECIPIENT,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Get email sender
     *
     * @return string
     */
    public function getEmailSender()
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_EMAIL_SENDER,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Get email template
     *
     * @return string
     */
    public function getEmailTemplate()
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_EMAIL_TEMPLATE,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Check if honeypot enabled
     *
     * @return bool
     */
    public function isHoneypotEnabled()
    {
        return $this->scopeConfig->isSetFlag(
            self::XML_PATH_HONEYPOT,
            ScopeInterface::SCOPE_STORE
        );
    }
}
