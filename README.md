# Magento 2 Shopping Cart Manager

The Shopping Cart Manager extension for Magento 2 allows store administrators to effectively monitor and manage customer shopping carts from the backend. This tool ensures quick access to cart data, enabling prompt customer support and streamlined inventory planning.

## Overview

The Shopping Cart Manager extension for Magento 2 allows store administrators to effectively monitor and manage customer shopping carts from the backend. This tool ensures quick access to cart data, enabling prompt customer support and streamlined inventory planning.

## Key Features

- **Enhanced Shopping Cart Management**: The Shopping Cart Manager extension offers a complete solution for overseeing your store’s cart system, providing you with the ability to view, analyze, and manage shopping carts effectively.
    - **View Cart List**: Access a detailed list of all shopping carts.
    - **Examine Details**: Review specific cart contents and customer information.
    - **Customer Insights**: Gain valuable insights into customer preferences and buying behavior.
    - **Convert to Orders**: Easily convert shopping carts into completed orders.

## Installation

To install the Shopping Cart Manager extension via Composer:

1. **Require the package**:
    ```bash
    composer require mintechhub/module-shopping-cart
    ```

2. **Enable the module**:
    ```bash
    bin/magento module:enable MinTechHub_ShoppingCart
    ```

3. **Run setup upgrade**:
    ```bash
    bin/magento setup:upgrade
    ```

4. **Deploy static content (if needed)**:
    ```bash
    bin/magento setup:static-content:deploy
    ```

5. **Clear the cache**:
    ```bash
    bin/magento cache:clean
    bin/magento cache:flush
    ```

By using the Shopping Cart Manager extension for Magento 2, you can ensure a smooth and efficient shopping experience for your customers while optimizing your store’s backend operations.



