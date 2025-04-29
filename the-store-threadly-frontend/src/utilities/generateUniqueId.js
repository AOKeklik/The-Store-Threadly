import React from 'react'

export default function generateUniqueId (product)  {
    return product.variantId 
        ? `product-id-${product.productId}_variant-id-${product.variantId}`
        : `product-id-${product.productId}`;
}
