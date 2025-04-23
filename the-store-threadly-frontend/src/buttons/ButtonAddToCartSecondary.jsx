import React from 'react'
import useCart from '../hooks/useCart'
// import "./ButtonPrimary.css"

export default function ButtonAddToCartSecondary({product}) {
    const { 
        isInCart, 
        isInStock, 
        addToCart 
    } = useCart()

    return isInStock(product) && (
        <div className="button-container">
            {
                isInCart(product) ? (
                    <i className="bi bi-cart-check text-success fs-5"></i>
                ) : (
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
                        className='btn border-0 small button-primary fill-primary py-1 px-2 small'
                    > BUY NOW</button>       
                )
            }
        </div>
    )
}
