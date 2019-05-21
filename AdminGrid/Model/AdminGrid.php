<?php

namespace Ktpl\AdminGrid\Model;

use Ktpl\AdminGrid\Api\Data\AdminGridInterface;
use Ktpl\AdminGrid\Model\ResourceModel\AdminGrid as ResourceAdminGrid;
use Magento\Framework\Model\AbstractModel;

use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Exception\LocalizedException;

/**
 * AdminGrid model
 *
 * @method ResourceAdminGrid _getResource()
 * @method ResourceAdminGrid getResource()
 * @method AdminGrid setStoreId(array $storeId)
 * @method array getStoreId()
 */
class AdminGrid extends AbstractModel implements AdminGridInterface
{
    /**
     * AdminGrid cache tag
     */
    const CACHE_TAG = 'ktpl_admin_grid';

    /**#@+
     * Banner's statuses
     */
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;

    /**#@-*/
    /**
     * @var string
     */
    protected $_cacheTag = 'ktpl_admin_grid';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'ktpl_admin_grid';

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Ktpl\AdminGrid\Model\ResourceModel\AdminGrid');
    }

    /**
     * Prevent banners recursion
     *
     * @return AbstractModel
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function beforeSave()
    {
        $needle = 'banner_id="' . $this->getId() . '"';
        if (false == strstr($this->getContent(), $needle)) {
            return parent::beforeSave();
        }
        throw new \Magento\Framework\Exception\LocalizedException(
            __('Make sure that static banner content does not reference the banner itself.')
        );
    }

    /**
     * Retrieve banner id
     *
     * @return int
     */
    public function getId()
    {
        return $this->getData(self::BANNER_ID);
    }

    /**
     * Retrieve banner image
     *
     * @return string
     */
    public function getImage()
    {
        return (string)$this->getData(self::IMAGE);
    }

    /**
     * Retrieve banner title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->getData(self::TITLE);
    }

    /**
     * Retrieve banner content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->getData(self::CONTENT);
    }    

    /**
     * Retrieve banner link
     *
     * @return string
     */
    public function getLink()
    {
        return $this->getData(self::LINK);
    }

    /**
     * Is active
     *
     * @return bool
     */
    public function isActive()
    {
        return (bool)$this->getData(self::IS_ACTIVE);
    }

    /**
     * Retrive Sort Order
     *
     * @return int
     */
    public function GetSortOrder()
    {
        return (bool)$this->getData(self::SORT_ORDER);
    }

    /**
     * Retrieve banner creation time
     *
     * @return string
     */
    public function getCreationTime()
    {
        return $this->getData(self::CREATION_TIME);
    }

    /**
     * Retrieve banner update time
     *
     * @return string
     */
    public function getUpdateTime()
    {
        return $this->getData(self::UPDATE_TIME);
    }

    /**
     * Set ID
     *
     * @param int $id
     * @return AdminGridInterface
     */
    public function setId($id)
    {
        return $this->setData(self::BANNER_ID, $id);
    }

    /**
     * Set image
     *
     * @param string $image
     * @return AdminGridInterface
     */
    public function setImage($image)
    {
        return $this->setData(self::IMAGE, $image);
    }

    /**
     * Set title
     *
     * @param string $title
     * @return AdminGridInterface
     */
    public function setTitle($title)
    {
        return $this->setData(self::TITLE, $title);
    }

    /**
     * Set content
     *
     * @param string $content
     * @return AdminGridInterface
     */
    public function setContent($content)
    {
        return $this->setData(self::CONTENT, $content);
    }   

    /**
     * Set link
     *
     * @param string $link
     * @return AdminGridInterface
     */
    public function setLink($link)
    {
        return $this->setData(self::LINK, $link);
    }

    /**
     * Set is active
     *
     * @param bool|int $isActive
     * @return AdminGridInterface
     */
    public function setIsActive($isActive)
    {
        return $this->setData(self::IS_ACTIVE, $isActive);
    }

    /**
     * Set Sort Order
     *
     * @param int $sortOrder
     * @return AdminGridInterface
     */
    public function setSortOrder($sortOrder)
    {
        return $this->setData(self::SORT_ORDER, $sortOrder);
    }

    /**
     * Set creation time
     *
     * @param string $creationTime
     * @return AdminGridInterface
     */
    public function setCreationTime($creationTime)
    {
        return $this->setData(self::CREATION_TIME, $creationTime);
    }

    /**
     * Set update time
     *
     * @param string $updateTime
     * @return AdminGridInterface
     */
    public function setUpdateTime($updateTime)
    {
        return $this->setData(self::UPDATE_TIME, $updateTime);
    }

    /**
     * Receive page store ids
     *
     * @return int[]
     */
    public function getStores()
    {
        return $this->hasData('stores') ? $this->getData('stores') : $this->getData('store_id');
    }

    /**
     * Prepare banner's statuses.
     *
     * @return array
     */
    public function getAvailableStatuses()
    {
        return [self::STATUS_ENABLED => __('Yes'), self::STATUS_DISABLED => __('No')];
    }
}
