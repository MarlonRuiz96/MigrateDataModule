<?php

/**
 * Grid Admin Cagegory Map Record Save Controller.
 * @category  Webkul
 * @package   Webkul_Grid
 * @author    Webkul
 * @copyright Copyright (c) 2010-2016 Webkul Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */
namespace Webkul\Grid\Controller\Adminhtml\Grid;

class Save extends \Magento\Backend\App\Action
{
    /**
     * @var \Webkul\Grid\Model\GridFactory
     */
    var $gridFactory;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Webkul\Grid\Model\GridFactory $gridFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Webkul\Grid\Model\GridFactory $gridFactory,
        \Webkul\Grid\Model\GridCloneFactory $gridCloneFactory // Nueva Factory

    ) {
        parent::__construct($context);
        $this->gridFactory = $gridFactory;
        $this->gridCloneFactory = $gridCloneFactory; // Asignar la nueva Factory

    }

    /**
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
        // Captura los datos del formulario
        $data = $this->getRequest()->getPostValue();

        // Validar si los datos están vacíos
        if (!$data) {
            $this->_redirect('grid/grid/addrow');
            return;
        }

        try {
            // Guardar en la tabla principal
            $rowData = $this->gridFactory->create();
            $rowData->setData($data);

            // Si el ID está presente, estamos editando
            if (isset($data['entity_id'])) {
                // Indicar que estamos editando un registro existente
                $rowData->setEntityId($data['entity_id']);
            }

            $rowData->save(); // Guarda la tabla principal

            // Si es una edición, clonar el registro
            if (isset($data['entity_id'])) {
                $this->clonarEnTablaClone($rowData, $data['entity_id']);
            }

            $this->messageManager->addSuccess(__('Dato ingresado o actualizado en la tabla principal con éxito.'));
        } catch (\Exception $e) {
            $this->messageManager->addError(__($e->getMessage()));
        }

        $this->_redirect('grid/grid/index');
    }

    /**
     * Método para clonar el registro en la tabla clon
     */
    private function clonarEnTablaClone($rowData, $originalId)
    {
        try {
            // Guardar en la tabla clon
            $cloneData = $this->gridCloneFactory->create();
            $cloneData->setTitle($rowData->getTitle());
            $cloneData->setOldEntityId($originalId); // Usar el id de la edición como referencia en la tabla clon
            $cloneData->setContent($rowData->getContent());
            $cloneData->setPublishDate($rowData->getPublishDate());
            $cloneData->setIsActive($rowData->getIsActive());
            $cloneData->setCreatedAt($rowData->getCreatedAt());
            $cloneData->setUpdateTime($rowData->getUpdateTime());
            $cloneData->save(); // Guarda la copia en la tabla clon

            $this->messageManager->addSuccess(__('El registro fue clonado exitosamente.'));
        } catch (\Exception $e) {
            $this->messageManager->addError(__($e->getMessage()));
        }
    }



    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Webkul_Grid::save');
    }
}
