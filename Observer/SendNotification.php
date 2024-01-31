<?php
/**
 * Copyright © 2016 Magevolve Ltd. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Me\Cmb\Observer;

use Magento\Framework\Event\ObserverInterface;
use Me\Cmb\Helper\Data as DataHelper;
use Psr\Log\LoggerInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Directory\Model\CountryFactory;
use Magento\Framework\App\Area;
use Magento\Framework\Exception\LocalizedException;

class SendNotification implements ObserverInterface
{
    /**
     * @var DataHelper
     */
    private $helper;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var StateInterface
     */
    private $inlineTranslation;

    /**
     * @var TransportBuilder
     */
    private $transportBuilder;

    /**
     * @var CountryFactory
     */
    private $countryFactory;

    /**
     * @param DataHelper $helper
     * @param LoggerInterface $logger
     * @param StateInterface $inlineTranslation
     * @param TransportBuilder $transportBuilder
     * @param CountryFactory $countryFactory
     */
    public function __construct(
        DataHelper $helper,
        LoggerInterface $logger,
        StateInterface $inlineTranslation,
        TransportBuilder $transportBuilder,
        CountryFactory $countryFactory
    ) {
        $this->helper = $helper;
        $this->logger = $logger;
        $this->inlineTranslation = $inlineTranslation;
        $this->transportBuilder = $transportBuilder;
        $this->countryFactory = $countryFactory;
    }

    /**
     * Send notification
     *
     * @param Observer $observer
     * @return $this
     */
    public function execute(Observer $observer)
    {
        if ($this->helper->isEnabled() && $this->helper->isEmailEnabled()) {
            /** @var \Me\Cmb\Model\Cmb $cmb */
            $cmb = $observer->getCmb();
            if ($cmb != null && $cmb->getId()) {
                try {
                    $this->inlineTranslation->suspend();

                    $countryName = '';
                    if ($cmb->getCmbCountry()) {
                        $country = $this->countryFactory->create()->load($cmb->getCmbCountry());
                        if ($country != null && $country->getId()) {
                            $countryName = $country->getName();
                        }
                    }

                    $templateVars = [
                        'cmb_full_name' => $cmb->getCmbFullName(),
                        'cmb_telephone' => $cmb->getCmbTelephone(),
                        'cmb_call_date' => $cmb->getCmbCallDate(),
                        'cmb_predefined' => $cmb->getCmbPredefined(),
                        'cmb_country' => $countryName
                    ];

                    $transport = $this->transportBuilder
                        ->setTemplateIdentifier($this->helper->getEmailTemplate())
                        ->setTemplateOptions(
                            [
                                'area' => Area::AREA_FRONTEND,
                                'store' => $cmb->getStoreId(),
                            ]
                        )
                        ->setTemplateVars($templateVars)
                        ->setFrom($this->helper->getEmailSender())
                        ->setReplyTo($this->helper->getEmailSender())
                        ->addTo($this->helper->getEmailRecipient())
                        ->getTransport();

                    $transport->sendMessage();
                    $this->inlineTranslation->resume();
                } catch (LocalizedException $e) {
                    $this->logger->warning($e->getMessage());
                    $this->inlineTranslation->resume();
                } catch (\RuntimeException $e) {
                    $this->logger->warning($e->getMessage());
                    $this->inlineTranslation->resume();
                } catch (\Exception $e) {
                    $this->logger->critical($e);
                    $this->inlineTranslation->resume();
                }
            }
        }

        return $this;
    }
}
