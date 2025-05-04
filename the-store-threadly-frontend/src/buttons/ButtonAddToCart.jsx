import React from 'react'
import useCart from '../hooks/order/useCart'
import { cartResource } from '../utilities/resources'
import { isInStock } from '../utilities/helpers'

export default function ButtonAddToCart({product,quantity=1,cb=()=>{}}) {
    const { 
        isInCart, 
        addToCart 
    } = useCart()

    return isInStock(product) && (
        <button 
            disabled={isInCart(product)}
            onClick={() => {
                addToCart(cartResource(product, quantity))
                cb()
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
