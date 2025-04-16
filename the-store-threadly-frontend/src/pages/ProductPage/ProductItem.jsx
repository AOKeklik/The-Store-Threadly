import React from 'react'

import { useSelector } from 'react-redux'

export default function ProductItem() {
    const filters = useSelector(state => state.filters)
    const {
        filteredData,
    } = useSelector(state => state.products);

    const getMatchingVariant = (product, filters) => {
        return product.variants?.find(variant => {
            const colorMatch = !filters.color || variant.attributes?.some(attr =>
                attr.attribute.slug === "color" && attr.slug === filters.color
            )
            const sizeMatch = !filters.size || variant.attributes?.some(attr =>
                attr.attribute.slug === "size" && attr.slug === filters.size
            )
            return colorMatch && sizeMatch
        })
    }

    return filteredData.data.map((product, i) => {
        const isFiltered = Object.values(filters).some(val => val)
        const selectedVariant = isFiltered ? getMatchingVariant(product, filters) : null
        const thumbnail = isFiltered && selectedVariant?.thumbnail ? selectedVariant.thumbnail : product.thumbnail
        const price = isFiltered && selectedVariant?.price_html ? selectedVariant.price_html : product.price_html
    
        return <div className='col-lg-4 col-md-6' key={i}>
            <div className="section-product-item">
                <div className="card border-light-subtle">
                    <div className="card-body p-0 position-relative">
                        <div className='position-absolute d-flex flex-column gap-2 p-2'>
                            {product.is_new > 0 && <span className="badge p-2 bg-warning">New</span>}
                            {product.offer_price && <span className="badge p-2 bg-danger">Sale</span>}
                        </div>
                        <img className='w-100' src={thumbnail} alt={product.title} />
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
                            <a href={`product/${product.slug}`} className="text-gray text-decoration-none hover-text-danger">
                                <h3 className='fs-6 p-0 m-0'>{product.title}</h3>
                            </a>
                            <small>{product.category_name}</small>
                        </div>
                        <div className='d-flex justify-content-between'>
                            <h3 className='fs-6 p-0 m-0 text-danger' dangerouslySetInnerHTML={{ __html: price }} />
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
        </div>
    })
}
