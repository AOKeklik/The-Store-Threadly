import React, { useState } from 'react'
import { useParams } from 'react-router-dom'

import { Swiper, SwiperSlide } from "swiper/react";
import { Navigation, Thumbs, FreeMode, Zoom } from "swiper/modules";
import "swiper/css";
import "swiper/css/navigation";
import "swiper/css/thumbs";
import "swiper/css/zoom";

import Baner from '../../components/layouts/Baner'
import HeadingPrimary from '../../components/layouts/HeadingPrimary'
import Loader from '../../components/layouts/Loader'

import useCart from '../../hooks/useCart'
import useProductFilter from '../../hooks/useProductSingleFilter'

import ButtonWishlist from '../../buttons/ButtonWishlist'
import ButtonSocialShare from '../../buttons/ButtonSocialShare'
import ButtonLink from '../../buttons/ButtonLink'
import ButtonAddToCart from '../../buttons/ButtonAddToCart'

import FeaturedProducts from '../../slider/FeaturedSlider'
import useProducts from '../../hooks/useProducts';

export default function ProductSinglePage() {
    const { slug } = useParams()

    const { 
        dataProduct,
        dataRelatedProduct,
        loadingProduct,
    } = useProducts(slug)

/* ////////// SWIPER ////////// */
    const [thumbsSwiper, setThumbsSwiper] = useState(null)
/* ////////// SWIPER ////////// */

/* ////////// FILTERING ////////// */
    const {
        selectedColor,
        selectedSize,
        colors,
        sizes,
        handleColorSelect,
        handleSizeSelect,
        productDisplay,
    } = useProductFilter(dataProduct);
/* ////////// FILTERING ////////// */

/* ////////// QUANTITY ////////// */
    const [quantity,setQuantity]=useState(1)
/* ////////// QUANTITY ////////// */

/* ////////// CART ////////// */
    const {
        isInCart,
        isInStock,
        getQuantity,
        getStockStatus,
    } = useCart()
/* ////////// CART ////////// */

    if(loadingProduct) return <Loader />

    return <div className='pb-5'>
        <Baner {...{
            title: productDisplay.title,
            cover: productDisplay.cover,
            breadcrumbs: [
                {path: "/products",label:"Products"},
                {path:"",label:productDisplay.title}
            ],
        }} />

        <main className='container-md mb-5'>
            <div className="row mb-5 bg-white rounded-1 shadow">
                {/* /////////// PRODUCT SLIDER /////////// */}
                <div className="col-md-4 text-center">
                    {/* Main Slider (Large Image) */}
                    <Swiper
                        zoom={true}
                        thumbs={{ swiper: thumbsSwiper && !thumbsSwiper.destroyed ? thumbsSwiper : null }}
                        modules={[Zoom, Navigation, Thumbs]}
                        navigation={{
                            nextEl: '.swiper-button-next-custom',
                            prevEl: '.swiper-button-prev-custom',
                        }}
                        onInit={(swiper) => {
                            // Ensure navigation elements exist
                            if (!swiper.navigation.nextEl || !swiper.navigation.prevEl) {
                                swiper.navigation.destroy();
                            }
                        }}
                    >
                        <SwiperSlide>
                            <div className="swiper-zoom-container">
                                <img src={productDisplay.thumbnail} alt="Product" className='w-100 max-w-25' />
                            </div>
                        </SwiperSlide>
                        {
                            productDisplay.galleries.map((gallery) => {
                                return <SwiperSlide>
                                    <div className="swiper-zoom-container">
                                        <img src={gallery.thumbnail} alt="Product" className='w-100 max-w-25' />
                                    </div>
                                </SwiperSlide>
                            })
                        }
                         {/* Arrows */}
                         <button className="swiper-button-prev-custom rounded-0 rounded-end btn btn-outline-secondary position-absolute top-50 start-0 translate-middle-y z-3">
                            <i className="bi bi-chevron-left"></i>
                        </button>
                        <button className="swiper-button-next-custom rounded-0 rounded-start btn btn-outline-secondary position-absolute top-50 end-0 translate-middle-y z-3">
                            <i className="bi bi-chevron-right"></i>
                        </button>
                    </Swiper>

                    {/* Thumbnail Slider */}
                    <Swiper
                        onSwiper={setThumbsSwiper}
                        freeMode={true}
                        slidesPerView={4}
                        spaceBetween={10}
                        modules={[FreeMode, Thumbs]}
                    >
                        <SwiperSlide>
                            <div className="swiper-zoom-container">
                                <img src={productDisplay.thumbnail} alt="Product" className='w-100 max-w-25' />
                            </div>
                        </SwiperSlide>
                        {
                            productDisplay.galleries.map((gallery) => {
                                return <SwiperSlide>
                                    <div className="swiper-zoom-container">
                                        <img src={gallery.thumbnail} alt="Product" className='w-100 max-w-25' />
                                    </div>
                                </SwiperSlide>
                            })
                        }
                    </Swiper>
                </div>
                {/* /////////// PRODUCT SLIDER /////////// */}

                <div className="col-md-8 py-4 px-4">
                    {/* /////////// TITLE /////////// */}
                    <div className='d-flex align-items-center mb-1 flex-column flex-sm-row justify-content-sm-between gap-2'>
                        <h2 className='fs-3 fw-bold p-0 m-0'>{productDisplay.title}</h2>
                        <div className='d-flex gap-1 align-items-center flex-column flex-lg-row'>
                            <div>
                                <i className="bi bi-star-fill"></i>
                                <i className="bi bi-star-fill"></i>
                                <i className="bi bi-star-fill"></i>
                                <i className="bi bi-star-half"></i>
                                <i className="bi bi-star"></i>
                            </div>
                            <span className='fs-08'>(27 Rating)</span>
                        </div>
                    </div>
                    {/* /////////// TITLE /////////// */}

                    {/* /////////// PRICE /////////// */}
                    <div className='mb-4'>
                        <h3 className='fs-5 p-0 m-0 text-danger' dangerouslySetInnerHTML={{ __html: productDisplay.price_html }} />
                    </div>
                    {/* /////////// PRICE /////////// */}

                    {/* /////////// SHORT DESCRIPTION /////////// */}
                    <p className='p-0 m-0 mb-4' dangerouslySetInnerHTML={{ __html: productDisplay.short_desc }} />
                    {/* /////////// SHORT DESCRIPTION /////////// */}
                    
                    {/* /////////// ATTRIBUTES /////////// */}
                    <div>
                        {/* Color selection */}
                        <div className="mb-3 d-flex gap-4 align-items-center">
                            <h6 className='p-0 m-0 w-3 text-end'>Color:</h6>
                            <div className="d-flex gap-2">
                                {colors.map(color => (
                                    <button
                                        key={color.slug}
                                        onClick={() => handleColorSelect(color.slug)}
                                        style={{
                                            padding: ".6rem",
                                            backgroundColor: color.icon,
                                            border: selectedColor === color.slug ? '2px solid #000' : '1px solid #ccc'
                                        }}
                                        className="btn btn-sm text-white"
                                        title={color.name}
                                    />
                                ))}
                            </div>
                        </div>

                        {/* Size selection */}
                        {sizes.length > 0 && (
                            <div className="mb-3 d-flex gap-4 align-items-center">
                                <h6 className='p-0 m-0 w-3 text-end'>Size:</h6>
                                <div className="d-flex gap-2">
                                    {sizes.map(size => (
                                        <button
                                            key={size.slug}
                                            onClick={() => handleSizeSelect(size.slug)}
                                            style={{
                                                border: selectedSize === size.slug ? '2px solid #000' : '1px solid #ccc'
                                            }}
                                            className="btn btn-sm btn-outline-secondary"
                                            disabled={!selectedColor}
                                        >
                                            {size.icon.toUpperCase()}
                                        </button>
                                    ))}
                                </div>
                            </div>
                        )}
                        
                        {/* Stock status */}
                        <div className="mb-3 d-flex gap-4 align-items-center">
                            <h6 className='p-0 m-0 w-3 text-end'>Stock:</h6>
                            <div className="d-flex gap-2">{getStockStatus(productDisplay)}</div>
                        </div>
                    </div>
                    {/* /////////// ATTRIBUTES /////////// */}

                    <div className="d-flex justify-content-start gap-3">
                        {/* /////////// QUANTITY BUTTONS /////////// */}
                        {
                            isInStock(productDisplay) && (
                                <div className="rounded d-flex gap-1">
                                    <button 
                                        disabled={isInCart(productDisplay)}
                                        onClick={() => setQuantity(prev => prev > 1 ? prev - 1 : 1)}
                                        className='btn bg-secondary-subtle p-3 hover-text-danger'
                                    >
                                        <i className="bi bi-dash-lg"></i>
                                    </button>
                                    <span className='bg-light px-2 py-3'>
                                        {
                                            isInCart(productDisplay) ? getQuantity(productDisplay) : quantity
                                        }
                                    </span>
                                    <button 
                                        disabled={isInCart(productDisplay)}
                                        onClick={() => setQuantity(prev => prev < productDisplay.stock ? prev + 1 : productDisplay.stock)}
                                        className='btn bg-secondary-subtle p-3 hover-text-danger'
                                    >
                                        <i className="bi bi-plus-lg"></i>
                                    </button>
                                </div>  
                            )
                        }
                        {/* /////////// QUANTITY BUTTONS /////////// */}

                        {/* /////////// ADD TO CART BUTTONS /////////// */}
                        <div className="rounded px-4 py-2 d-flex gap-4 bg-secondary-subtle align-items-center">
                            <ButtonWishlist product={productDisplay} />
                            <ButtonSocialShare product={productDisplay} />
                            <ButtonLink product={productDisplay} />
                            <ButtonAddToCart product={productDisplay} />
                        </div>
                        {/* /////////// ADD TO CART BUTTONS /////////// */}
                    </div>
                </div>
            </div>

            {/* /////////// REVIEWS & DESCRIPTIONS /////////// */}
            <div className="row g-4 mb-5 shadow p-3">
                <ul className="col-md-3 list-group" id="myTab" role="tablist">
                    <button className="list-group-item list-group-item-action nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">Description</button>
                    <button className="list-group-item list-group-item-action nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">Reviews</button>
                </ul>
                <div className="col-md-9 tab-content bg-white rounded-1 p-4" id="myTabContent">
                    <div className="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabIndex="0">
                        <HeadingPrimary title={`DUMMY ${productDisplay.title.toUpperCase()}`} size='small' />
                        <p className='p-0 m-0 mb-4' dangerouslySetInnerHTML={{ __html: productDisplay.desc }} />
                    </div>
                    <div className="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabIndex="0">
                        <HeadingPrimary title="CUSTOMER REVIEWS" size='small' />
                        <p className='p-0 m-0' dangerouslySetInnerHTML={{ __html: productDisplay.desc }} />
                    </div>
                </div>
            </div>
            {/* /////////// REVIEWS & DESCRIPTIONS /////////// */}

            {/* /////////// RELATED PRODUCTS /////////// */}
            {
                dataRelatedProduct.length > 0 && <HeadingPrimary title="Related Products" />
            }
            <FeaturedProducts data={dataRelatedProduct} />
            {/* /////////// RELATED PRODUCTS /////////// */}
        </main>
    </div>
}
