<?php
/**
 * Copyright © 2016 Magevolve Ltd. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Me\Cmb\Controller\Adminhtml\Cmb;

use Magento\Backend\App\Action;
use Magento\Backend\Model\View\Result\Redirect;

class Delete extends Action
{
    /**
     * Delete action
     *
     * @return Redirect
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('cmb_id');
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($id) {
            $title = "";
            try {
                // init model and delete
                $model = $this->_objectManager->create('Me\Cmb\Model\Cmb');
                $model->load($id);
                $title = $model->getTitle();
                $model->delete();
                $this->messageManager->addSuccessMessage(__('The item has been deleted.'));
                $this->_eventManager->dispatch(
                    'adminhtml_cmb_on_delete',
                    ['title' => $title, 'status' => 'success']
                );
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->_eventManager->dispatch(
                    'adminhtml_cmb_on_delete',
                    ['title' => $title, 'status' => 'fail']
                );
                $this->messageManager->addErrorMessage($e->getMessage());
                return $resultRedirect->setPath('*/*/edit', ['cmb_id' => $id]);
            }
        }
        $this->messageManager->addErrorMessage(__('We can\'t find the item to delete.'));

        return $resultRedirect->setPath('*/*/');
    }
}
