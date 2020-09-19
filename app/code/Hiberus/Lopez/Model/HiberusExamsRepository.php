<?php

namespace Hiberus\Lopez\Model;

use Hiberus\Lopez\Api\Data\HiberusExamsInterface;
use Hiberus\Lopez\Api\HiberusExamsRepositoryInterface;
use Hiberus\Lopez\Model\ResourceModel\HiberusExams as ResourceHiberusExams;
use Hiberus\Lopez\Model\ResourceModel\HiberusExams\CollectionFactory as HiberusExamsCollectionFactory;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Hiberus\Lopez\Api\Data\HiberusExamsSearchResultInterfaceFactory;

/**
 * Class HiberusExamsRepository
 * @package Hiberus\Lopez\Model
 */
class HiberusExamsRepository implements HiberusExamsRepositoryInterface
{
    /**
     * @var ResourceHiberusExams
     */
    protected $_resource;

    /**
     * @var HiberusExamsFactory
     */
    protected $_hiberusExamsFactory;

    /**
     * @var HiberusExamsCollectionFactory
     */
    protected $_hiberusExamsCollection;

    /**
     * @var CollectionProcessorInterface
     */
    protected $_collectionProcessor;

    /**
     * @var HiberusExamsSearchResultInterfaceFactory
     */
    protected $_searchResultFactory;

    /**
     * HiberusExamsRepository constructor.
     * @param ResourceHiberusExams $resource
     * @param HiberusExamsFactory $hiberusExamsFactory
     * @param HiberusExamsCollectionFactory $hiberusExamsCollectionFactory
     * @param CollectionProcessorInterface $collectionProcessor
     * @param HiberusExamsSearchResultInterfaceFactory $searchResultInterfaceFactory
     */
    public function __construct(
        ResourceHiberusExams $resource,
        HiberusExamsFactory $hiberusExamsFactory,
        HiberusExamsCollectionFactory $hiberusExamsCollectionFactory,
        CollectionProcessorInterface $collectionProcessor,
        HiberusExamsSearchResultInterfaceFactory $searchResultInterfaceFactory
    ) {
        $this->_resource               = $resource;
        $this->_hiberusExamsFactory    = $hiberusExamsFactory;
        $this->_hiberusExamsCollection = $hiberusExamsCollectionFactory;
        $this->_collectionProcessor    = $collectionProcessor;
        $this->_searchResultFactory    = $searchResultInterfaceFactory;
    }

    /**
     * Save Hiberus Exam
     * @param $hiberusExam
     * @return bool
     * @throws CouldNotSaveException
     */
    public function save($hiberusExam)
    {
        try {
            $this->_resource->save($hiberusExam);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }
        return $hiberusExam;
    }

    /**
     * Get Hiberus Exam By ID
     * @param $idExam
     * @return HiberusExamsInterface|HiberusExams
     * @throws NoSuchEntityException
     */
    public function getByIdExam($idExam)
    {
        $hiberusExams = $this->_hiberusExamsFactory->create();
        $this->_resource->load($hiberusExams, $idExam);
        if (!$hiberusExams->getIdExam()) {
            throw new NoSuchEntityException(__('Exam with id "%1" does not exists.', $idExam));
        }
        return $hiberusExams;
    }

    /**
     * Get List of Hiberus Exams
     * @param SearchCriteriaInterface $searchCriteria
     * @return \Hiberus\Lopez\Api\Data\HiberusExamsSearchResultInterface|\Hiberus\Lopez\Api\Data\HiberusExamsSearchResultInterface[]
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        $collection = $this->_hiberusExamsCollection->create();

        $this->_collectionProcessor->process($searchCriteria, $collection);

        $searchResults = $this->_searchResultFactory->create();

        $searchResults->setItems($collection->getItems());

        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;
    }

    /**
     * Delete Hiberus Exam
     * @param HiberusExamsInterface $hiberusExam
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(HiberusExamsInterface $hiberusExam)
    {
        try {
            $idExam = $hiberusExam->getIdExam();
            $this->_resource->delete($hiberusExam);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }

        return true;
    }

    /**
     * Delete Hiberus Exam By ID exam
     * @param $idExam
     * @return bool
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteByIdExam($idExam)
    {
        return $this->delete($this->getByIdExam($idExam));
    }
}
