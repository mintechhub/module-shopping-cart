<?php
/**
 * NOTICE OF LICENSE
 *
 *   Copyright (c) 2024 MinTechHub <saif.ali@mintechhub.com> - MinTechHub
 *   All rights reserved
 *
 *   This product includes proprietary software developed at MinTechHub
 *   For more information see https://www.mintechhub.com/
 *
 *   To obtain a valid license for using this software please contact us at saif.ali@mintechhub.com
 */

declare(strict_types=1);

/**
 * @copyright  2024 MinTechHub <saif.ali@mintechhub.com> - MinTechHub
 * @see       https://www.mintechhub.com/
 * @author     Saif Ali <saif.ali@mintechhub.com>
 */

namespace MinTechHub\ShoppingCart\Controller\Adminhtml\Carts;

use MinTechHub\ShoppingCart\Controller\Adminhtml\Carts;

class Order extends Carts
{
    /**
     * Execute method to convert the quote to an order.
     *
     * @return \Magento\Framework\Controller\Result\Redirect
     */
    public function execute()
    {
        $quoteId = $this->getRequest()->getParam("quote_id");
        $quote = $this->getQuote($quoteId);

        /**
         * @var \Magento\Backend\Model\Session\Quote $quoteSession
         */
        $quoteSession   = $this->_objectManager->get(
            \Magento\Backend\Model\Session\Quote::class
        );
        $quoteSession->setQuoteId($quoteId);
        $resultRedirect = $this->resultRedirectFactory->create();

        return $resultRedirect->setPath(
            "sales/order_create/index",
            ['customer_id' => $quote->getCustomerId(), 'store_id' => $quote->getStoreId()]
        );
    }
}
