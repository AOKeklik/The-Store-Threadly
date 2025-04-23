import React from 'react'
import ButtonAddToCart from '../../buttons/ButtonAddToCart'
import ButtonLink from '../../buttons/ButtonLink'
import ButtonSocialShare from '../../buttons/ButtonSocialShare'
import ButtonWishlist from '../../buttons/ButtonWishlist'
import DisplayAttributes from '../../displays/DisplayAttributes'
import DisplayStatus from '../../displays/DisplayStatus'

export default function ProductPrymaryItem({product}) {
    return <div className="section-product-item">
        <div className="card border-light-subtle">
            <div className="card-body p-0 position-relative">
                {/* ////////// STATUS ////////// */}
                <div className='position-absolute d-flex flex-column align-items-start gap-2 p-2'>
                    <DisplayStatus product={product} sale news best />
                </div>
                {/* ////////// STATUS ////////// */}

                {/* ////////// THUMBNAIL ////////// */}
                <img className='w-100' src={product.thumbnail} alt="" />
                {/* ////////// THUMBNAIL ////////// */}

                {/* ////////// ADD TO CART BUTTON ////////// */}
                <div className="icon-box-container d-flex justify-content-center shadow-lg">
                    <div className="icon-box bg-white rounded shadow-sm px-3 py-2 d-flex gap-4">
                        <ButtonWishlist product={product} />
                        <ButtonSocialShare product={product} />
                        <ButtonLink product={product} />
                        <ButtonAddToCart product={product} />
                    </div>
                </div>
                {/* ////////// ADD TO CART BUTTON ////////// */}

                <DisplayAttributes product={product} />
            </div>
            <div className="card-footer p-3 border-0 ">
                {/* ////////// TITLE ////////// */}
                <div className='d-flex justify-content-between mb-1'>
                    <a href={`product/${product.slug}`} className="text-gray text-decoration-none hover-text-danger">
                        <h3 className='fs-6 p-0 m-0'>{product.title}</h3>
                    </a>
                    <small>{product.category.name}</small>
                </div>
                {/* ////////// TITLE ////////// */}

                {/* ////////// STARS ////////// */}
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
                {/* ////////// STARS ////////// */}
            </div>
        </div>
    </div>
}