<?php
namespace Ktpl\AdminGrid\Api\Data;

/**
 * AdminGrid interface.
 * @api
 */
interface AdminGridInterface
{
    /**#@+
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    const BANNER_ID      = 'banner_id';
    const IMAGE          = 'image';
    const TITLE          = 'title';
    const CONTENT        = 'content';  
    const LINK           = 'link';
    const IS_ACTIVE      = 'is_active';
    const SORT_ORDER     = 'sort_order';
    const CREATION_TIME  = 'creation_time';
    const UPDATE_TIME    = 'update_time';
    /**#@-*/

    /**
     * Get ID
     *
     * @return int|null
     */
    public function getId();

    /**
     * Get image
     *
     * @return string
     */
    public function getImage();

    /**
     * Get title
     *
     * @return string|null
     */
    public function getTitle();

    /**
     * Get content
     *
     * @return string|null
     */
    public function getContent(); 

    /**
     * Get link
     *
     * @return string|null
     */
    public function getLink();

    /**
     * Is active
     *
     * @return bool|null
     */
    public function isActive();

    /**
     * Get Sort Order
     *
     * @return int|null
     */
    public function getSortOrder();

    /**
     * Get creation time
     *
     * @return string|null
     */
    public function getCreationTime();

    /**
     * Get update time
     *
     * @return string|null
     */
    public function getUpdateTime();

    /**
     * Set ID
     *
     * @param int $id
     * @return AdminGridInterface
     */
    public function setId($id);

    /**
     * Set image
     *
     * @param string $image
     * @return AdminGridInterface
     */
    public function setImage($image);
   
    /**
     * Set content
     *
     * @param string $content
     * @return AdminGridInterface
     */
    public function setContent($content);   

    /**
     * Set link
     *
     * @param string $link
     * @return AdminGridInterface
     */
    public function setLink($link);

    /**
     * Set Sort Order
     *
     * @param string $sortOrder
     * @return AdminGridInterface
     */
    public function setSortOrder($sortOrder);

    /**
     * Set is active
     *
     * @param bool|int $isActive
     * @return AdminGridInterface
     */
    public function setIsActive($isActive);

    /**
     * Set creation time
     *
     * @param string $creationTime
     * @return AdminGridInterface
     */
    public function setCreationTime($creationTime);

    /**
     * Set update time
     *
     * @param string $updateTime
     * @return AdminGridInterface
     */
    public function setUpdateTime($updateTime);
}
