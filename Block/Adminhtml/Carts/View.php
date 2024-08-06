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

namespace MinTechHub\ShoppingCart\Block\Adminhtml\Carts;

use Magento\Backend\Block\Widget\Context;
use Magento\Backend\Block\Widget\Form\Container;
use Magento\Framework\Registry;
use Magento\Quote\Model\Quote;
use Magento\Sales\Model\Order;

/**
 * Class View
 *
 * Provides functionality to view and manage the shopping cart details in the admin panel.
 */
class View extends Container
{
    /**
     *
     * @var string
     */
    protected $_blockGroup = 'MinTechHub_ShoppingCart';

    /**
     * @var \Magento\Framework\AuthorizationInterface
     */
    protected $authorization;

    /**
     * @var Registry
     */
    protected $registry;

    /**
     * @var Quote
     */
    private $quoteDetails = null;

    /**
     * @var Order
     */
    private $order;

    /**
     * View constructor.
     *
     * @param Context  $context
     * @param Registry $registry
     * @param Order    $order
     * @param array    $data
     */
    public function __construct(
        Context  $context,
        Registry $registry,
        Order    $order,
        array    $data
    ) {
        $this->registry = $registry;
        $this->order = $order;

        parent::__construct($context, $data);
    }

    /**
     * Initialize the View container.
     */
    protected function _construct()
    {
        $this->_objectId = 'id';
        $this->_controller = 'adminhtml_carts';
        $this->_mode = 'view';
        $this->authorization = $this->getAuthorization();

        parent::_construct();

        $this->buttonList->remove('delete');
        $this->buttonList->remove('reset');
        $this->buttonList->remove('save');
        $this->setId('mintechhub_cart_grid');

        $this->quoteDetails = $this->getQuoteData();
        if ($this->isAllowedAction('Magento_Sales::create') &&
            $this->isAllowedAction('MinTechHub_ShoppingCart::cart_convert') &&
            $this->canBeConvertedToOrder()
        ) {
            $this->buttonList->add(
                'convert_quote',
                [
                    'label'          => __('Convert to Order'),
                    'class'          => __('action-primary'),
                    'id'             => 'convert-to-order',
                    'onclick'        => 'setLocation(\'' . $this->getOrderUrl() . '\')',
                    'data_attribute' => [
                        'url' => $this->getOrderUrl(),
                    ],
                ]
            );
        }

        if ($this->isConvertedToCart()) {
            $this->buttonList->add(
                'view_order_details',
                [
                    'label'          => __('View Order Details'),
                    'class'          => __('action-primary'),
                    'id'             => 'view_order_details',
                    'onclick'        => 'setLocation(\'' . $this->getOrderDetailsUrl() . '\')',
                    'data_attribute' => [
                        'url' => $this->getOrderDetailsUrl(),
                    ],
                ]
            );
        }
    }

    /**
     * Get the URL for a specific route.
     *
     * @param string $params
     * @param array $params2
     * @return string
     */
    public function getUrl($params = '', $params2 = [])
    {
        $params2['quote_id'] = $this->getQuoteId();

        return parent::getUrl($params, $params2);
    }

    /**
     * Edit URL getter
     *
     * @return string
     */
    public function getOrderUrl()
    {
        return $this->getUrl('*/*/order');
    }

    /**
     * Check if the action is allowed
     *
     * @param string $resourceId
     * @return bool
     */
    protected function isAllowedAction($resourceId)
    {
        return $this->authorization->isAllowed($resourceId);
    }

    /**
     * Get the quote ID from the registry.
     *
     * @return int
     */
    protected function getQuoteId()
    {
        return $this->registry->registry("quoteData")->getId();
    }

    /**
     * Get quote data from the registry.
     *
     * @return Quote
     */
    public function getQuoteData()
    {
        return $this->registry->registry("quoteData");
    }

    /**
     * Check if the quote can be converted to an order.
     *
     * @return bool
     */
    public function canBeConvertedToOrder()
    {
        if (! $this->isConvertedToCart() &&
            $this->quoteDetails->getIsActive() === '1'
        ) {
            return true;
        }

        return false;
    }

    /**
     * Check if the quote has been converted to a cart.
     *
     * @return bool
     */
    public function isConvertedToCart()
    {
        return $this->quoteDetails->getReservedOrderId() !== null;
    }

    /**
     * Get the URL for the order details.
     *
     * @return string
     */
    public function getOrderDetailsUrl()
    {
        return parent::getUrl(
            'sales/order/view',
            ['order_id' => $this->getOrderId($this->quoteDetails->getReservedOrderId())]
        );
    }

    /**
     * Get the order ID by the increment ID.
     *
     * @param string $incrementId
     * @return int
     */
    public function getOrderId($incrementId)
    {
        $order = $this->order->loadByIncrementId($incrementId);

        return $order->getId();
    }
}
