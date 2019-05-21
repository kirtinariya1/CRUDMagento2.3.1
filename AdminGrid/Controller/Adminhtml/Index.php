<?php
namespace Ktpl\AdminGrid\Controller\Adminhtml;

abstract class Index extends \Magento\Backend\App\Action
{
    protected function initPage($resultPage)
    {
        $resultPage->setActiveMenu('Ktpl_AdminGrid::admingrid')->addBreadcrumb(__('Admin Management'), __('Admin Management'));
        return $resultPage;
    }
}
