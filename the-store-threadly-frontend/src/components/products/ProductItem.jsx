import React from 'react'

import useInViewAnimation from '../hooks/useInViewAnimation'

export default function ProductItem({product}) {
    const { ref, style } = useInViewAnimation({ direction: "top" })

    return <div 
            ref={ref} 
		    style={style}
            className="section-product-item"
        >
        <div className="card border-light-subtle">
            <div className="card-body p-0 position-relative">
                {
                    product.offer_price && (
                        <span className="badge p-2 m-2 bg-danger position-absolute">Sale</span>
                    )
                }
                <img className='w-100' src={product.thumbnail} alt="" />
                <div className="icon-box-container d-flex justify-content-center shadow-lg">
                    <div className="icon-box bg-white rounded shadow-sm px-3 py-2 d-flex gap-4">
                        <i className="bi bi-heart icon-hover"></i>
                        <i className="bi bi-eye icon-hover"></i>
                        <i className="bi bi-box-arrow-up-right icon-hover"></i>
                        <i className="bi bi-cart icon-hover"></i>
                    </div>
                </div>
            </div>
            <div className="card-footer p-3 border-0 ">
                <div className='d-flex justify-content-between mb-1'>
                    <h3 className='fs-6 p-0 m-0'>{product.title}</h3>
                    <small>{product.category_name}</small>
                </div>
                <div className='d-flex justify-content-between'>
                    <h3 className='fs-6 p-0 m-0 text-danger'>{product.price_html}</h3>
                    <div>
                        <i className="bi bi-star-fill"></i>
                        <i className="bi bi-star-fill"></i>
                        <i className="bi bi-star-fill"></i>
                        <i className="bi bi-star-half"></i>
                        <i className="bi bi-star"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
}