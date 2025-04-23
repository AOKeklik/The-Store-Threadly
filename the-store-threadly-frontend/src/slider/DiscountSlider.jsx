import React from 'react'

import 'swiper/css/bundle'
import {Swiper, SwiperSlide} from 'swiper/react'
import {Autoplay,Navigation,Pagination} from "swiper/modules"

import ButtonPrimary from '../buttons/ButtonPrimary'

import AnimateInView from "../hooks/AnimateInView"
import useCart from '../hooks/useCart'
import { URL_PRODUCT } from '../config'

export default function DiscountSlider({data}) {
    const { getItemDiscountPercent, getItemPrice } = useCart()

    return <AnimateInView direction='up'>
        <section id="section-discount-products" className='container-md mb-5'>
            <Swiper
                spaceBetween={16}
                slidesPerView={1} 
                loop={true}
                pagination={{ clickable: true }}
                speed={2000}
                modules={[Pagination,Autoplay,Navigation]}
                className='h-full relative lg:mt-10 mt-7'
                autoplay={{delay: 10500}}
            >
                {/* Item */}
                {
                    data.filter(n => n.offer_price).slice(0,12).map((product, i) => (
                        <SwiperSlide className='position-relative' key={i}>
                            <img src={product.cover} alt="" />
                            <div className="position-absolute top-50 end-0 translate-middle-y text-white p-5">
                                <p className='sale position-absolute top-0 end-0 bg-danger rounded-circle d-flex justify-content-center align-content-center flex-column text-center translate-middle'>
                                    <span>On Sale</span>
                                    <span></span>
                                    <span className='fw-bold'>{getItemPrice(product)}</span>
                                </p>
                                <p className='animate__animated animate__fadeInDown m-0 fs-1 text-danger fw-bold'>
                                    DISCOUNT {getItemDiscountPercent(product)}
                                </p>
                                <p className='animate__animated animate__fadeInUp lh-1 mb-4 w-75 fs-5'>
                                    {product.short_desc.slice(0,150).concat("...")}
                                </p>
                                <ButtonPrimary text="See Details" size='small' fill="primary" href={`${URL_PRODUCT}/${product.slug}`} />
                            </div>
                        </SwiperSlide>
                    ))
                }
            </Swiper> 
        </section>
    </AnimateInView>
}