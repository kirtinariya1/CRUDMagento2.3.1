<?php
namespace Ktpl\AdminGrid\Block;

class AdminGrid extends \Magento\Framework\View\Element\Template
{
	protected $_itemCollectionFactory;

	public function __construct(
		\Magento\Framework\View\Element\Template\Context $context,
        \Ktpl\AdminGrid\Model\ResourceModel\AdminGrid\CollectionFactory $itemCollectionFactory,
        \Ktpl\AdminGrid\Helper\Image $imageHelper,
        array $data = []
    ) {
        $this->_itemCollectionFactory = $itemCollectionFactory;
        $this->imageurl = $imageHelper->_getUrl();
        parent::__construct($context, $data);
    }

    public function getItemCollection(){
	    $collection = $this->_itemCollectionFactory->create();
        $collection->addFieldToFilter('is_active', ['eq' => '1'])
                ->setOrder('sort_order', 'ASC');
        return $collection;
	}
}
