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

namespace MinTechHub\ShoppingCart\Block\Adminhtml;

use Magento\Backend\Block\Widget\Grid\Container;

/**
 * Class Carts
 *
 * Provides functionality to display and manage the container for the shopping carts grid in the admin panel.
 */
class Carts extends Container
{
    /**
     * Initialize the Carts container.
     */
    protected function _construct()
    {
        $this->_blockGroup = 'MinTechHub_ShoppingCart';
        $this->_controller = 'adminhtml_mintechhubCarts';
        $this->_headerText = __('Carts');
        parent::_construct();
    }
}
