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

namespace MinTechHub\ShoppingCart\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\Pricing\Helper\Data as PriceHelper;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;

/**
 * Class Data
 *
 * Provides helper functions for formatting amounts and times.
 */
class Data extends AbstractHelper
{
    /**
     * @var PriceHelper
     */
    protected $priceHelper;

    /**
     * @var TimezoneInterface
     */
    protected $timezone;

    /**
     * Data constructor.
     *
     * @param Context           $context
     * @param TimezoneInterface $timezone
     * @param PriceHelper       $priceHelper
     */
    public function __construct(
        Context $context,
        TimezoneInterface $timezone,
        PriceHelper $priceHelper
    ) {
        parent::__construct($context);
        $this->priceHelper = $priceHelper;
        $this->timezone = $timezone;
    }

    /**
     * Format the given amount as currency.
     *
     * @param float $amount
     * @param bool  $container
     * @return string
     */
    public function formatAmount($amount, $container = true)
    {
        return $this->priceHelper->currency($amount, true, $container);
    }

    /**
     * Get formatted time.
     *
     * @param string|null $time
     * @param string      $format
     * @return string
     */
    public function getFormattedTime($time = null, $format = "Y-m-d H:i:s")
    {
        if ($time !== null) {
            $time = strtotime($time);
        }

        return $this->timezone->date($time)->format($format);
    }
}
