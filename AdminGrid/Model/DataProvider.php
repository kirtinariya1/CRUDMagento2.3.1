<?php
namespace Ktpl\AdminGrid\Model;

use Ktpl\AdminGrid\Model\ResourceModel\AdminGrid\CollectionFactory;
use Magento\Framework\App\Request\DataPersistorInterface;
use Ktpl\AdminGrid\Helper\Image;

/**
 * Class DataProvider
 */
class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /**
     * @var \Ktpl\AdminGrid\Model\ResourceModel\Banner\Collection
     */
    protected $collection;

    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var array
     */
    protected $loadedData;

    /**
     * Constructor
     *
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $bannerCollectionFactory
     * @param DataPersistorInterface $dataPersistor
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $bannerCollectionFactory,
        DataPersistorInterface $dataPersistor,
        Image $imageUrl,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $bannerCollectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        $this->imageUrl = $imageUrl->_getUrl();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        /** @var \Ktpl\AdminGrid\Model\AdminGrid $banner */
        foreach ($items as $banner) {
            $bannerData = $banner->getData();
            if (isset($bannerData['image'])) {
                unset($bannerData['image']);
                $bannerData['image'][0]['name'] = $banner->getData('image');
                $bannerData['image'][0]['url'] = $this->imageUrl . $banner->getData('image');
            }
            $this->loadedData[$banner->getId()] = $bannerData;
        }

        $data = $this->dataPersistor->get('ktpl_home_banner');
        if (!empty($data)) {
            $banner = $this->collection->getNewEmptyItem();
            $banner->setData($data);
            $this->loadedData[$banner->getId()] = $banner->getData();
            $this->dataPersistor->clear('ktpl_home_banner');
        }

        return $this->loadedData;
    }
}
