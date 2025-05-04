import React from 'react'

import DisplayAttributes from '../../displays/DisplayAttributes'

import ButtonSocialShare from '../../buttons/ButtonSocialShare'
import ButtonWishlist from '../../buttons/ButtonWishlist'
import ButtonAddToCart from '../../buttons/ButtonAddToCart'
import ButtonLink from '../../buttons/ButtonLink'

import { isInStock } from '../../utilities/helpers'

export default function ProductItem({ product }) {    
    return (
        <div className='col-lg-4 col-md-6'>
            <div className="section-product-item">
                <div className="card border-light-subtle">
                    <div className="card-body p-0 position-relative">
                        {/* /////////// STATUS /////////// */}
                        <div className='position-absolute d-flex justify-content-between p-2 w-100'>
                            <div className='d-flex flex-column gap-2'>
                                {product.is_new > 0 && <span className="badge p-2 bg-warning">New</span>}
                                {product.offer_price && <span className="badge p-2 bg-danger">Sale</span>}
                            </div>
                            <div>
                                {!isInStock(product) && <span className='text-danger'>Out of stock</span>}
                            </div>
                        </div>
                        {/* /////////// STATUS /////////// */}

                        
                        {/* /////////// IMAGE /////////// */}
                        <img className='w-100' src={product.thumbnail} alt={product.title} />
                        {/* /////////// IMAGE /////////// */}

                        
                        {/* /////////// COLOR - SIZE /////////// */}
                        <DisplayAttributes product={product} />                           
                        {/* /////////// COLOR - SIZE /////////// */}

                        {/* /////////// ADD TO CART BUTTONS /////////// */}
                        <div className="icon-box-container d-flex justify-content-center shadow-lg">
                            <div className="icon-box bg-white rounded shadow-sm px-3 py-2 d-flex gap-4">
                                <ButtonWishlist product={product} />
                                <ButtonSocialShare product={product} />
                                <ButtonLink product={product} />
                                <ButtonAddToCart product={product} />
                            </div>
                        </div>
                        {/* /////////// ADD TO CART BUTTONS /////////// */}
                    </div>

                    {/* /////////// PRODUCT TITLE /////////// */}
                    <div className="card-footer p-3 border-0 ">
                        <div className='d-flex justify-content-between mb-1'>
                            <a href={`product/${product.slug}`} className="text-gray text-decoration-none hover-text-danger">
                                <h3 className='fs-6 p-0 m-0'>{product.title}</h3>
                            </a>
                            <small>{product.category?.name}</small>
                        </div>
                        <div className='d-flex justify-content-between'>
                            <h3 className='fs-6 p-0 m-0 text-danger' dangerouslySetInnerHTML={{ __html: product.price_html }} />
                            <div>
                                <i className="bi bi-star-fill"></i>
                                <i className="bi bi-star-fill"></i>
                                <i className="bi bi-star-fill"></i>
                                <i className="bi bi-star-half"></i>
                                <i className="bi bi-star"></i>
                            </div>
                        </div>
                    </div>
                    {/* /////////// PRODUCT TITLE /////////// */}
                </div>
            </div>
        </div>
    )
}