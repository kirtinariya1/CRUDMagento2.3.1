<?php
namespace Ktpl\AdminGrid\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface AdminGridRepositoryInterface
{
    /**
     * Save banner.
     *
     * @param \Ktpl\AdminGrid\Api\Data\AdminGridInterface $banner
     * @return \Ktpl\AdminGrid\Api\Data\AdminGridInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(\Ktpl\AdminGrid\Api\Data\AdminGridInterface $banner);

    /**
     * Retrieve banner.
     *
     * @param int $bannerId
     * @return \Ktpl\AdminGrid\Api\Data\AdminGridInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($bannerId);

    /**
     * Retrieve banners matching the specified criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Ktpl\AdminGrid\Api\Data\AdminGridSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);

    /**
     * Delete banner.
     *
     * @param \Ktpl\AdminGrid\Api\Data\AdminGridInterface $banner
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(\Ktpl\AdminGrid\Api\Data\AdminGridInterface $banner);

    /**
     * Delete banner by ID.
     *
     * @param int $bannerId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($bannerId);
}
