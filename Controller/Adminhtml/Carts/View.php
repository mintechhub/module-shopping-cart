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

use Magento\Framework\Controller\ResultFactory;
use MinTechHub\ShoppingCart\Controller\Adminhtml\Carts;

/**
 * Class View
 *
 * Provides functionality to view the details of a specific shopping cart in the admin panel.
 */
class View extends Carts
{
    /**
     * Execute method to render the cart details page.
     *
     * @return \Magento\Backend\Model\View\Result\Page|\Magento\Framework\Controller\Result\Redirect
     */
    public function execute()
    {
        try {
            $quoteId = $this->getRequest()->getParam('quote_id');
            $this->registry->register('quoteData', $this->getQuote($quoteId));
            /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
            $resultPage = $this->pageFactory->create();
            $resultPage->setActiveMenu('mintechhub_cart::mintechhub_cart');
            $resultPage->getConfig()->getTitle()->prepend(__('Cart Details'));
            $resultPage->addBreadcrumb(__('Carts'), __('Carts'));
            $resultPage->addBreadcrumb(__('Cart Details'), __('Cart Details'));

            return $resultPage;
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
            $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
            $resultRedirect->setUrl($this->_redirect->getRefererUrl());

            return $resultRedirect;
        }
    }
}
