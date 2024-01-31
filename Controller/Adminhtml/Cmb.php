<?php
/**
 * Copyright © 2016 Magevolve Ltd. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Me\Cmb\Controller\Adminhtml;

use Magento\Backend\App\Action;
use Magento\Framework\Registry;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Page;

abstract class Cmb extends Action
{
    /**
     * Core registry
     *
     * @var Registry
     */
    private $coreRegistry = null;

    /**
     * @param Context $context
     * @param Registry $coreRegistry
     */
    public function __construct(
        Context $context,
        Registry $coreRegistry
    ) {
        $this->coreRegistry = $coreRegistry;
        parent::__construct($context);
    }

    /**
     * Init page
     *
     * @param Page $resultPage
     * @return Page
     */
    public function _initPage($resultPage)
    {
        $resultPage->setActiveMenu('Me_Cmb::me_cmb')
            ->addBreadcrumb(__('Request a Callback'), __('Request a Callback'))
            ->addBreadcrumb(__('Manage Callbacks'), __('Manage Callbacks'));
        return $resultPage;
    }

    /**
     * Check the permission to run it
     *
     * @return boolean
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Me_Cmb::me_cmb');
    }
}
