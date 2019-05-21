<?php

namespace Ktpl\AdminGrid\Block\Adminhtml\AdminGrid\Edit;

use Magento\Backend\Block\Widget\Context;
use Ktpl\AdminGrid\Api\AdminGridRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Class GenericButton
 */
class GenericButton
{
    /**
     * @var Context
     */
    protected $context;

    /**
     * @var AdminGridRepositoryInterface
     */
    protected $bannerManagementRepository;

    /**
     * @param Context $context
     * @param AdminGridRepositoryInterface $bannerRepository
     */
    public function __construct(
        Context $context,
        AdminGridRepositoryInterface $bannerRepository
    ) {
        $this->context = $context;
        $this->bannerRepository = $bannerRepository;
    }

    /**
     * Return CMS block ID
     *
     * @return int|null
     */
    public function getBannerId()
    {
        try {
            return $this->bannerRepository->getById(
                $this->context->getRequest()->getParam('id')
            )->getId();
        } catch (NoSuchEntityException $e) {           
        }
        return null;
    }

    /**
     * Generate url by route and parameters
     *
     * @param   string $route
     * @param   array $params
     * @return  string
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}