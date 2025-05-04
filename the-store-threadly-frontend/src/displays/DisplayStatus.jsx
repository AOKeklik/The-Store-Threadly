import React from 'react'
import { getItemDiscountPercent } from '../utilities/helpers'


export default function DisplayStatus({product,news=false,sale=false,best=false}) {
    
    return <>
        {
            best && product.is_best_seller !== 0 && (
                <span className="badge p-2 bg-danger opacity-75">Best Seller</span>
            )
        }
        {
            news && product.is_new !== 0 && (
                <span className="badge p-2 bg-danger opacity-75">New</span>
            )
        }
        {
            sale && product.offer_price && (
                <span className="badge p-2 bg-danger opacity-75">{getItemDiscountPercent(product)}</span>
            )
        }
    </>
}
