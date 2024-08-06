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

namespace MinTechHub\ShoppingCart\Controller\Adminhtml;

use Magento\Backend\App\Action;
use Magento\Framework\Exception\NotFoundException;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use Magento\Quote\Model\QuoteRepository;

/**
 * Abstract class Carts
 *
 * Provides common functionality for the shopping cart controllers in the admin panel.
 */
abstract class Carts extends Action
{
    /**
     * @var PageFactory
     */
    protected $pageFactory;

    /**
     * @var QuoteRepository
     */
    protected $quoteRepository;

    /**
     * @var Registry
     */
    protected $registry;

    /**
     * @var \Magento\Framework\Controller\Result\RedirectFactory
     */
    protected $resultRedirectFactory;

    /**
     * Carts constructor.
     *
     * @param Action\Context  $context
     * @param PageFactory     $pageFactory
     * @param QuoteRepository $quoteRepository
     * @param Registry        $registry
     */
    public function __construct(
        Action\Context  $context,
        PageFactory     $pageFactory,
        QuoteRepository $quoteRepository,
        Registry        $registry
    ) {
        $this->quoteRepository       = $quoteRepository;
        $this->registry              = $registry;
        $this->resultFactory         = $context->getResultFactory();
        $this->pageFactory           = $pageFactory;
        $this->resultRedirectFactory = $context->getResultRedirectFactory();
        parent::__construct($context);
    }

    /**
     * Determine if authorized to perform group actions.
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('MinTechHub_ShoppingCart::cart_grid');
    }

    /**
     * Get the quote by ID.
     *
     * @param int $quoteId
     * @return \Magento\Quote\Model\Quote
     * @throws NotFoundException
     */
    protected function getQuote($quoteId)
    {
        $quote = $this->quoteRepository->get($quoteId);
        if (! $quote->getId()) {
            throw new NotFoundException(__('Quote does not exists'));
        }

        return $quote;
    }
}
