<?php

namespace Ktpl\AdminGrid\Model;

use Ktpl\AdminGrid\Api\Data;
use Ktpl\AdminGrid\Api\AdminGridRepositoryInterface;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Reflection\DataObjectProcessor;
use Ktpl\AdminGrid\Model\ResourceModel\AdminGrid as ResourceAdminGrid;
use Ktpl\AdminGrid\Model\ResourceModel\AdminGrid\CollectionFactory as AdminGridCollectionFactory;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class AdminGridRepository
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class AdminGridRepository implements AdminGridRepositoryInterface
{
    /**
     * @var ResourceAdminGrid
     */
    protected $resource;

    /**
     * @var AdminGridFactory
     */
    protected $bannerFactory;

    /**
     * @var AdminGridCollectionFactory
     */
    protected $bannerCollectionFactory;

    /**
     * @var Data\AdminGridSearchResultsInterfaceFactory
     */
    protected $searchResultsFactory;

    /**
     * @var DataObjectHelper
     */
    protected $dataObjectHelper;

    /**
     * @var DataObjectProcessor
     */
    protected $dataObjectProcessor;

    /**
     * @var \Ktpl\AdminGrid\Api\Data\AdminGridInterfaceFactory
     */
    protected $dataBannerFactory;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    private $storeManager;

    /**
     * @param ResourceAdminGrid $resource
     * @param AdminGridFactory $bannerFactory
     * @param Data\AdminGridInterfaceFactory $dataBannerFactory
     * @param AdminGridCollectionFactory $bannerCollectionFactory
     * @param Data\AdminGridSearchResultsInterfaceFactory $searchResultsFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param DataObjectProcessor $dataObjectProcessor
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        ResourceAdminGrid $resource,
        AdminGridFactory $bannerFactory,
        \Ktpl\AdminGrid\Api\Data\AdminGridInterfaceFactory $dataBannerFactory,
        AdminGridCollectionFactory $bannerCollectionFactory,
        Data\AdminGridSearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        StoreManagerInterface $storeManager
    ) {
        $this->resource = $resource;
        $this->bannerFactory = $bannerFactory;
        $this->bannerCollectionFactory = $bannerCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataBannerFactory = $dataBannerFactory;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->storeManager = $storeManager;
    }

    /**
     * Save AdminGrid data
     *
     * @param \Ktpl\AdminGrid\Api\Data\AdminGridInterface $banner
     * @return AdminGrid
     * @throws CouldNotSaveException
     */
    public function save(Data\AdminGridInterface $banner)
    {
        $storeId = $this->storeManager->getStore()->getId();
        $banner->setStoreId($storeId);
        try {
            $this->resource->save($banner);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }
        return $banner;
    }

    /**
     * Load Banner data by given Banner Identity
     *
     * @param string $bannerId
     * @return Banner
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById($bannerId)
    {
        $banner = $this->bannerFactory->create();
        $this->resource->load($banner, $bannerId);
        if (!$banner->getId()) {
            throw new NoSuchEntityException(__('Banner with id "%1" does not exist.', $bannerId));
        }
        return $banner;
    }

    /**
     * Load Banner data collection by given search criteria
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     * @param \Magento\Framework\Api\SearchCriteriaInterface $criteria
     * @return \Ktpl\AdminGrid\Model\ResourceModel\AdminGrid\Collection
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $criteria)
    {
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);

        $collection = $this->bannerCollectionFactory->create();
        foreach ($criteria->getFilterGroups() as $filterGroup) {
            foreach ($filterGroup->getFilters() as $filter) {
                if ($filter->getField() === 'store_id') {
                    $collection->addStoreFilter($filter->getValue(), false);
                    continue;
                }
                $condition = $filter->getConditionType() ?: 'eq';
                $collection->addFieldToFilter($filter->getField(), [$condition => $filter->getValue()]);
            }
        }
        $searchResults->setTotalCount($collection->getSize());
        $sortOrders = $criteria->getSortOrders();
        if ($sortOrders) {
            foreach ($sortOrders as $sortOrder) {
                $collection->addOrder(
                    $sortOrder->getField(),
                    ($sortOrder->getDirection() == SortOrder::SORT_ASC) ? 'ASC' : 'DESC'
                );
            }
        }
        $collection->setCurPage($criteria->getCurrentPage());
        $collection->setPageSize($criteria->getPageSize());
        $banners = [];
        /** @var Banner $bannerModel */
        foreach ($collection as $bannerModel) {
            $bannerData = $this->dataBannerFactory->create();
            $this->dataObjectHelper->populateWithArray(
                $bannerData,
                $bannerModel->getData(),
                'Ktpl\AdminGrid\Api\Data\AdminGridInterface'
            );
            $banners[] = $this->dataObjectProcessor->buildOutputDataArray(
                $bannerData,
                'Ktpl\AdminGrid\Api\Data\AdminGridInterface'
            );
        }
        $searchResults->setItems($banners);
        return $searchResults;
    }

    /**
     * Delete Banner
     *
     * @param \Ktpl\AdminGrid\Api\Data\AdminGridInterface $banner
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(Data\AdminGridInterface $banner)
    {
        try {
            $this->resource->delete($banner);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }
        return true;
    }

    /**
     * Delete Banner by given Banner Identity
     *
     * @param string $bannerId
     * @return bool
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById($bannerId)
    {
        return $this->delete($this->getById($bannerId));
    }
}
