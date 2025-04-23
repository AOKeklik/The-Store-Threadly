import React from 'react'
import useCart from '../hooks/useCart'

export default function ButtonAddToCart({product}) {
    const { 
        isInCart, 
        isInStock, 
        addToCart 
    } = useCart()

    return isInStock(product) && (
        <button 
            disabled={isInCart(product)}
            onClick={() => {
                addToCart({ 
                    productId: product.productId,
                    variantId: product.variantId,
                    slug: product.slug,
                    title: product.title,
                    price :product.price,
                    price_html: product.price_html,
                    thumbnail: product.thumbnail,
                    maxQuantity: product.stock,
                    color:product.color,
                    size:product.size,
                })
            }}
            className='btn hover-text-danger border-0 fs-5 p-0'
        >
            {
                isInCart(product) ? (
                    <i className="bi bi-cart-check text-success"></i>
                ) : (
                    <i className="bi bi-cart"></i>
                )
            }
        </button>
    )
}
