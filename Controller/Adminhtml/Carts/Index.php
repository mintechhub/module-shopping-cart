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

/**
 * Class Index
 *
 * Provides functionality to display the list of shopping carts in the admin panel.
 */
class Index extends Carts
{
    /**
     * Execute method to render the cart list page.
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->pageFactory->create();
        $resultPage->setActiveMenu('mintechhub_cart::mintechhub_cart');
        $resultPage->getConfig()->getTitle()->prepend(__('Cart List'));
        $resultPage->addBreadcrumb(__('Carts'), __('Carts'));
        $resultPage->addBreadcrumb(__('Cart List'), __('Cart List'));

        return $resultPage;
    }
}
