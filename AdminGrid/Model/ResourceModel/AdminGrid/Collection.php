<?php
namespace Ktpl\AdminGrid\Model\ResourceModel\AdminGrid;

use Ktpl\AdminGrid\Api\Data\AdminGridInterface;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Banner Collection
 */
class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'banner_id';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Ktpl\AdminGrid\Model\AdminGrid', 'Ktpl\AdminGrid\Model\ResourceModel\AdminGrid');
    }
}
