<?php

namespace Webkul\Grid\Model\ResourceModel\GridClone;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'entity_id';
    /**
     * Define resource model.
     */

    protected function _construct()
    {
        $this->_init(
            'Webkul\Grid\Model\Model\GridClone',
            'Webkul\Grid\Model\ResourceModel\GridClone');
    }
}