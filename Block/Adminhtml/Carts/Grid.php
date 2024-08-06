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

use Magento\Backend\Block\Template\Context;
use Magento\Backend\Block\Widget\Grid\Extended;
use Magento\Backend\Helper\Data;
use Magento\Customer\Model\CustomerFactory;
use Magento\Quote\Model\Quote;
use MinTechHub\ShoppingCart\Helper\Data as Helper;

/**
 * Class Grid
 *
 * Provides functionality to display and manage the grid of shopping carts in the admin panel.
 */
class Grid extends Extended
{
    /**
     * @var Quote
     */
    private $quote;

    /**
     * @var CustomerFactory
     */
    private $customerFactory;

    /**
     * @var Helper
     */
    private $helper;

    /**
     * Grid constructor.
     *
     * @param Context            $context
     * @param Data               $backendHelper
     * @param Quote              $quote
     * @param CustomerFactory    $customerFactory
     * @param Helper             $helper
     * @param array              $data
     */
    public function __construct(
        Context            $context,
        Data               $backendHelper,
        Quote              $quote,
        CustomerFactory    $customerFactory,
        Helper             $helper,
        array              $data = []
    ) {
        $this->quote           = $quote;
        $this->helper          = $helper;
        $this->customerFactory = $customerFactory;
        parent::__construct($context, $backendHelper, $data);
    }

    /**
     * Initialize the grid.
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('mintechhub_carts');
        $this->setUseAjax(false);
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('desc');
        $this->setSaveParametersInSession(true);
    }

    /**
     * Prepare the collection of quotes.
     *
     * @return \Magento\Backend\Block\Widget\Grid\Extended
     */
    protected function _prepareCollection()
    {
        $collection = $this->quote->getCollection();
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    /**
     * Get the URL for a specific row.
     *
     * @param \Magento\Framework\DataObject $row
     * @return string
     */
    public function getRowUrl($row)
    {
        return $this->getUrl(
            '*/*/view',
            [
                'quote_id' => $row->getId(),
            ]
        );
    }

    /**
     * Prepare the columns for the grid.
     *
     * @return \Magento\Backend\Block\Widget\Grid\Extended
     */
    protected function _prepareColumns()
    {
        $this->addColumn('entity_id', [
            'header' => __('ID'),
            'type'   => 'number',
            'index'  => 'entity_id',
        ]);

        $this->addColumn('customer_firstname', [
            'header'         => __('First Name'),
            'type'           => 'text',
            'index'          => 'customer_firstname',
            'frame_callback' => [$this, 'appendUserLink'],
        ]);
        $this->addColumn('customer_lastname', [
            'header'         => __('Last Name'),
            'type'           => 'text',
            'index'          => 'customer_lastname',
            'frame_callback' => [$this, 'appendUserLink'],
        ]);

        $this->addColumn('is_active', [
            'header'  => __('Is Active'),
            'type'    => 'options',
            'options' => ['No', 'Yes'],
            'index'   => 'is_active',
        ]);

        $this->addColumn('customer_is_guest', [
            'header'  => __('Guest?'),
            'type'    => 'options',
            'options' => ['No', 'Yes'],
            'index'   => 'customer_is_guest',
        ]);

        $this->addColumn('items_count', [
            'header' => __('Items Count'),
            'type'   => 'number',
            'index'  => 'items_count',
        ]);
        $this->addColumn('subtotal', [
            'header'         => __('Sub Total'),
            'type'           => 'number',
            'index'          => 'subtotal',
            'frame_callback' => [$this, 'formatAmount'],
        ]);
        $this->addColumn('grand_total', [
            'header'         => __('Grand Total'),
            'type'           => 'number',
            'index'          => 'grand_total',
            'frame_callback' => [$this, 'formatAmount'],
        ]);

        $this->addColumn('store_id', [
            'header'  => __('Store'),
            'type'    => 'options',
            'options' => $this->getStores(),
            'index'   => 'store_id',
        ]);

        $this->addColumn('created_at', [
            'header' => __('Created At'),
            'type'   => 'datetime',
            'index'  => 'created_at',
        ]);
        $this->addColumn('updated_at', [
            'header' => __('Updated At'),
            'type'   => 'datetime',
            'index'  => 'updated_at',
        ]);

        $this->addColumn(
            'edit',
            [
                'header'  => __('View'),
                'type'    => 'action',
                'getter'  => 'getId',
                'actions' => [
                    [
                        'caption' => __('View'),
                        'url'     => [
                            'base' => '*/*/view',
                        ],
                        'field' => 'quote_id',
                    ],
                ],
                'filter'           => false,
                'sortable'         => false,
                'index'            => 'stores',
                'header_css_class' => 'col-action',
                'column_css_class' => 'col-action',
            ]
        );

        return parent::_prepareColumns();
    }

    /**
     * Append a link to the customer's profile in the grid.
     *
     * @param string $value
     * @param \Magento\Framework\DataObject $row
     * @return string|null
     */
    public function appendUserLink($value, $row)
    {
        if (empty($value)) {
            return;
        }

        return '<a href="' . $this->getUrl(
            'customer/index/edit/',
            ['id' => $row['customer_id']]
        ) . '">' . $value . ' </a>';
    }

    /**
     * Get a list of all stores.
     *
     * @return array
     */
    public function getStores()
    {
        $stores = $this->_storeManager->getStores();
        $storeNames = [];
        foreach ($stores as $storeId => $store) {
            $storeNames[$storeId] = $store->getName();
        }

        return $storeNames;
    }

    /**
     * Get the customer's name by their ID.
     *
     * @param int $value
     * @return string|null
     */
    public function getCustomerName($value)
    {
        /**
         * @var \Magento\Customer\Model\Customer $customer;
         */
        if ($value) {
            $customer = $this->customerFactory->create()->getMagentoCustomer()->load($value);

            return $customer->getName();
        }

        return null;
    }

    /**
     * Format the given amount using the helper.
     *
     * @param float $amount
     * @return string
     */
    public function formatAmount($amount)
    {
        return $this->helper->formatAmount($amount);
    }
}
