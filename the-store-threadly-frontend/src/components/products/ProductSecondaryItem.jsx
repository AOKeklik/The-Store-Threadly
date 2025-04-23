import React from 'react'
import DisplayAttributes from '../../displays/DisplayAttributes'
import ButtonAddToCartSecondary from '../../buttons/ButtonAddToCartSecondary'
import { Link } from 'react-router-dom'
import { URL_PRODUCT } from '../../config'
import DisplayStatus from '../../displays/DisplayStatus'

export default function ProductSecondaryItem({product}) {
    return <>
        <div className="card border-light-subtle">
            <div className="card-header d-flex justify-content-between p-2 w-100 border-0">
                <DisplayStatus product={product} news />
                <span dangerouslySetInnerHTML={{ __html: product.price_html }} />
            </div>
            <div className="card-body p-0 position-relative">
                <img className='object-fit-contain' src={product.thumbnail} alt="" />
                <DisplayAttributes product={product} />   
            </div>
            <div className="card-footer d-flex align-items-center justify-content-between p-2 border-0 ">
                <div>
                    <Link to={`${URL_PRODUCT}/${product.slug}`} className="text-gray text-decoration-none hover-text-danger">
                        <h3 className='fs-6 p-0 m-0'>{product.title}</h3>
                    </Link>
                    <small>{product.category_name}</small>
                </div>
                <ButtonAddToCartSecondary product={product} />
            </div>
        </div>
    </>
}