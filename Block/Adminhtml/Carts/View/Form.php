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

namespace MinTechHub\ShoppingCart\Block\Adminhtml\Carts\View;

use Magento\Backend\Block\Template;
use Magento\Customer\Model\CustomerFactory;
use Magento\Framework\Registry;
use Magento\Quote\Model\Quote;
use MinTechHub\ShoppingCart\Helper\Data;

/**
 * Class Form
 *
 * Provides functionality to view and manage shopping cart details in the admin panel.
 */
class Form extends Template
{
    /**
     * @var string
     */
    protected $_template = 'carts/form.phtml';

    /**
     * @var Registry
     */
    protected $registry = null;

    /**
     * @var CustomerFactory
     */
    protected $customerFactory;

    /**
     * @var Data
     */
    protected $helper;

    /**
     * Form constructor.
     *
     * @param Template\Context $context
     * @param Registry         $registry
     * @param CustomerFactory  $customerFactory
     * @param Data             $helper
     * @param array            $data
     */
    public function __construct(
        Template\Context $context,
        Registry $registry,
        CustomerFactory $customerFactory,
        Data $helper,
        array $data
    ) {
        $this->registry = $registry;
        $this->helper = $helper;
        $this->customerFactory = $customerFactory;
        parent::__construct($context, $data);
    }

    /**
     * Get the quote details from the registry.
     *
     * @return mixed
     */
    public function getQuoteDetails()
    {
        return $this->registry->registry('quoteData');
    }

    /**
     * Get the customer's name based on their ID.
     *
     * @param int $value
     * @return string|null
     */
    public function getCustomerName($value)
    {
        if ($value) {
            $customer = $this->customerFactory->create()->load($value);
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

    /**
     * Get the URL for the customer's profile based on the quote data.
     *
     * @param Quote $quote
     * @return string
     */
    public function getCustomerUrl($quote)
    {
        $data = $quote->getData();

        if (isset($data['customer_id']) && $data['customer_id']) {
            return $this->getUrl(
                'customer/index/edit',
                ['id' => $quote['customer_id']]
            );
        }

        return '';
    }

    /**
     * Get the URL for the product based on the item data.
     *
     * @param \Magento\Quote\Model\Quote\Item $item
     * @return string
     */
    public function getProductUrl($item)
    {
        if ($item && $item->getProductId()) {
            return $this->getUrl(
                'catalog/product/edit/',
                ['id' => $item->getProductId()]
            );
        }

        return '';
    }
}
