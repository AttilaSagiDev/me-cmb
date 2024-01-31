<?php
/**
 * Copyright © 2016 Magevolve Ltd. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Me\Cmb\Model;

use Me\Cmb\Api\Data;
use Me\Cmb\Api\CmbRepositoryInterface;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Reflection\DataObjectProcessor;
use Me\Cmb\Model\ResourceModel\Cmb as ResourceCmb;
use Me\Cmb\Model\ResourceModel\Cmb\CollectionFactory as CmbCollectionFactory;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Me\Cmb\Model\ResourceModel\Cmb\Collection;
use Me\Cmb\Api\Data\CmbInterface;

/**
 * Class CmbRepository
 */
class CmbRepository implements CmbRepositoryInterface
{
    /**
     * @var ResourceCmb
     */
    private $resource;

    /**
     * @var CmbFactory
     */
    private $cmbFactory;

    /**
     * @var CmbCollectionFactory
     */
    private $cmbCollectionFactory;

    /**
     * @var Data\CmbSearchResultsInterfaceFactory
     */
    private $searchResultsFactory;

    /**
     * @var DataObjectHelper
     */
    private $dataObjectHelper;

    /**
     * @var DataObjectProcessor
     */
    private $dataObjectProcessor;

    /**
     * @var Data\CmbInterfaceFactory
     */
    private $dataCmbFactory;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    private $storeManager;

    /**
     * @param ResourceCmb $resource
     * @param CmbFactory $cmbFactory
     * @param Data\CmbInterfaceFactory $dataCmbFactory
     * @param CmbCollectionFactory $cmbCollectionFactory
     * @param Data\CmbSearchResultsInterfaceFactory $searchResultsFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param DataObjectProcessor $dataObjectProcessor
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        ResourceCmb $resource,
        CmbFactory $cmbFactory,
        Data\CmbInterfaceFactory $dataCmbFactory,
        CmbCollectionFactory $cmbCollectionFactory,
        Data\CmbSearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        StoreManagerInterface $storeManager
    ) {
        $this->resource = $resource;
        $this->cmbFactory = $cmbFactory;
        $this->cmbCollectionFactory = $cmbCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataCmbFactory = $dataCmbFactory;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->storeManager = $storeManager;
    }

    /**
     * Save Cmb data
     *
     * @param CmbInterface $cmb
     * @return Cmb
     * @throws CouldNotSaveException
     */
    public function save(CmbInterface $cmb)
    {
        if (empty($cmb->getStoreId())) {
            $storeId = $this->storeManager->getStore()->getId();
            $cmb->setStoreId($storeId);
        }
        try {
            $this->resource->save($cmb);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the item: %1',
                $exception->getMessage()
            ));
        }
        return $cmb;
    }

    /**
     * Load Cmb data by given Cmb Id
     *
     * @param string $cmbId
     * @return Cmb
     * @throws NoSuchEntityException
     */
    public function getById($cmbId)
    {
        $cmb = $this->cmbFactory->create();
        $this->resource->load($cmb, $cmbId);
        if (!$cmb->getId()) {
            throw new NoSuchEntityException(__('Cmb item with id "%1" does not exist.', $cmbId));
        }
        return $cmb;
    }

    /**
     * Load Cmb data collection by given search criteria
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     * @param SearchCriteriaInterface $criteria
     * @return Collection
     */
    public function getList(SearchCriteriaInterface $criteria)
    {
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);

        $collection = $this->cmbCollectionFactory->create();
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
        $cmbs = [];
        /** @var Cmb $cmbModel */
        foreach ($collection as $cmbModel) {
            $cmbData = $this->dataCmbFactory->create();
            $this->dataObjectHelper->populateWithArray(
                $cmbData,
                $cmbModel->getData(),
                'Me\Cmb\Api\Data\CmbInterface'
            );
            $cmbs[] = $this->dataObjectProcessor->buildOutputDataArray(
                $cmbData,
                'Me\Cmb\Api\Data\CmbInterface'
            );
        }
        $searchResults->setItems($cmbs);
        return $searchResults;
    }

    /**
     * Delete Cmb item
     *
     * @param CmbInterface $cmb
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(CmbInterface $cmb)
    {
        try {
            $this->resource->delete($cmb);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }
        return true;
    }

    /**
     * Delete Cmb item by given Cmb Id
     *
     * @param string $cmbId
     * @return bool
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById($cmbId)
    {
        return $this->delete($this->getById($cmbId));
    }
}
