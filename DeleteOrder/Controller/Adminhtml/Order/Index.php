<?php

namespace CloudyDigitals\DeleteOrder\Controller\Adminhtml\Order;

use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use CloudyDigitals\DeleteOrder\Controller\Adminhtml\AbstractDelete;

class Index extends AbstractDelete
{
    /**
     * @return ResponseInterface|ResultInterface|void
     */
    public function execute()
    {
        $orderId = $this->getRequest()->getParam('order_id');
        if (!isset($orderId)) {
            $this->messageManager->addErrorMessage(__('Please Select an Order'));
            return $this->resultRedirectFactory->create()->setPath(
                'sales/order/index'
            );
        }
        try {
            $orderData = $this->orderRepository->get($orderId);
            $this->deleteOrder($orderData);
            $this->messageManager->addSuccessMessage(
                __('The Order Against Id ' . $orderId . ' has been Removed')
            );
        } catch (\Exception $exception) {
            $this->messageManager->addExceptionMessage(
                $exception,
                $exception->getMessage()
            );
        }
        return $this->resultRedirectFactory->create()->setPath(
            'sales/order/index'
        );
    }
}
