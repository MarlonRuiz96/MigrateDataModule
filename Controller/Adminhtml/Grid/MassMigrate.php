<?php
/**
 * Marlon :D Grid Record Migrate Controller.
 * 2024
 */
namespace Webkul\Grid\Controller\Adminhtml\Grid;

use Magento\Framework\Controller\ResultFactory;
use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use Webkul\Grid\Model\ResourceModel\Grid\CollectionFactory;
use Webkul\Grid\Model\GridCloneFactory;

class MassMigrate extends \Magento\Backend\App\Action
{
    /**
     * Massactions filter.
     * @var Filter
     */
    protected $_filter;

    /**
     * @var CollectionFactory
     */
    protected $_collectionFactory;

    /**
     * @var GridCloneFactory
     */
    protected $gridCloneFactory;

    /**
     * @param Context           $context
     * @param Filter            $filter
     * @param CollectionFactory $collectionFactory
     * @param GridCloneFactory  $gridCloneFactory
     */
    public function __construct(
        Context $context,
        Filter $filter,
        CollectionFactory $collectionFactory,
        GridCloneFactory $gridCloneFactory
    ){
        $this->_filter = $filter;
        $this->_collectionFactory = $collectionFactory;
        $this->gridCloneFactory = $gridCloneFactory;

        parent::__construct($context);
    }

    /**
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        $collection = $this->_filter->getCollection($this->_collectionFactory->create());

        try {
            $recordsUpdated = 0;
            $recordsCloned = 0;

            foreach ($collection->getItems() as $record) {
                $record->setData('is_active', 0);
                $record->save();
                $cloneData = $this->gridCloneFactory->create();
                $cloneData->setTitle($record->getTitle());
                $cloneData->setOldEntityId($record->getEntityId());
                $cloneData->setContent($record->getContent());
                $cloneData->setPublishDate($record->getPublishDate());
                $cloneData->setIsActive($record->getIsActive());
                $cloneData->setCreatedAt($record->getCreatedAt());
                $cloneData->setUpdateTime($record->getUpdateTime());
                $cloneData->save();
                $recordsUpdated++;
                $recordsCloned++;
            }

            $this->messageManager->addSuccessMessage(
                __('A total of %1 record(s) have been updated and cloned successfully.', $recordsUpdated)
            );
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(
                __('Error while processing records: %1', $e->getMessage())
            );
        }

        return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)->setPath('*/*/index');
    }

    /**
     * Check Category Map record delete Permission.
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Webkul_Grid::row_data_delete');
    }
}
