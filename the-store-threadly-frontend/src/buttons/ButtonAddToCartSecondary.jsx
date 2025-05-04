import React from 'react'
import useCart from '../hooks/order/useCart'
import { cartResource } from '../utilities/resources'
import { isInStock } from '../utilities/helpers'

export default function ButtonAddToCartSecondary({product}) {
    const { 
        isInCart,  
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
                            addToCart(cartResource(product))
                        }}
                        className='btn border-0 small button-primary fill-primary py-1 px-2 small'
                    > BUY NOW</button>       
                )
            }
        </div>
    )
}
