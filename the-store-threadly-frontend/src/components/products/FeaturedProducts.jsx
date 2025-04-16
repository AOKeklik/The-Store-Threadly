import React from 'react'

import 'swiper/css/bundle'
import "swiper/css"
import "swiper/css/navigation"
import {Swiper, SwiperSlide} from 'swiper/react'
import {Autoplay,Navigation} from "swiper/modules"

import ProductPrymaryItem from './ProductPrymaryItem'
import AnimateInView from '../hooks/AnimateInView'

export default function FeaturedProducts({data}) {
    return <AnimateInView direction="up">
        <section id="section-featured-products" className='container-md mb-5'>
            <Swiper
                spaceBetween={10}
                loop={true}
                pagination={{ clickable: true }}
                speed={400}
                modules={[Autoplay,Navigation]}
                autoplay={{delay: 4000}}
                breakpoints={{
                    900: {
                        slidesPerView: 2,
                    },
                    1280: {
                        slidesPerView: 3,
                    },
                }}
                navigation={{
                    nextEl: '.swiper-button-next-custom',
                    prevEl: '.swiper-button-prev-custom',
                }}
            >
                {
                    data.map((product, i) => <SwiperSlide key={i}>
                            <ProductPrymaryItem product={product} />
                        </SwiperSlide>
                    )
                }
                {/* Arrows */}
                <button className="swiper-button-prev-custom rounded-0 rounded-end btn btn-outline-secondary position-absolute top-50 start-0 translate-middle-y z-3">
                    <i className="bi bi-chevron-left"></i>
                </button>
                <button className="swiper-button-next-custom rounded-0 rounded-start btn btn-outline-secondary position-absolute top-50 end-0 translate-middle-y z-3">
                    <i className="bi bi-chevron-right"></i>
                </button>
            </Swiper> 
        </section>
    </AnimateInView>
}