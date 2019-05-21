<?php

namespace Ktpl\AdminGrid\Controller\Adminhtml\Item;

use Magento\Backend\App\Action\Context;
use Ktpl\AdminGrid\Model\AdminGrid;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\TestFramework\Inspection\Exception;

class Save extends \Ktpl\AdminGrid\Controller\Adminhtml\Index
{
    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;
    protected $_coreRegistry = null;

    /**
     * @param Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     * @param DataPersistorInterface $dataPersistor
     */
    public function __construct(
        Context $context,
        \Magento\Framework\Registry $coreRegistry,
        DataPersistorInterface $dataPersistor
    ) {
        $this->dataPersistor = $dataPersistor;
        $this->_coreRegistry = $coreRegistry;
        parent::__construct($context);
    }

    /**
     * Save action
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();
        if ($data) {
            $id = $this->getRequest()->getParam('id');

            if (isset($data['is_active']) && $data['is_active'] === 'true') {
                $data['is_active'] = Banner::STATUS_ENABLED;
            }
            if (empty($data['banner_id'])) {
                $data['banner_id'] = null;
            }

            if (isset($data['image']['0'])) {
                $data['image'] = $data['image']['0']['name'];
            }
            else {
                $data['image'] = NULL;
            }

            /** @var \Ktpl\AdminGrid\Model\AdminGrid $model */
            $model = $this->_objectManager->create('Ktpl\AdminGrid\Model\AdminGrid')->load($id);
            if (!$model->getId() && $id) {
                $this->messageManager->addError(__('This banner no longer exists.'));
                return $resultRedirect->setPath('*/*/');
            }

            $model->setData($data);
            $model->setUpdateTime(strtotime('now'));

            try {
                $model->save();
                $this->messageManager->addSuccess(__('You saved the banner.'));
                $this->dataPersistor->clear('ktpl_home_banner');

                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['id' => $model->getId()]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the banner.'));
            }

            $this->dataPersistor->set('ktpl_home_banner', $data);
            return $resultRedirect->setPath('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}
