import React from 'react'

import 'swiper/css/bundle'
import "swiper/css"
import "swiper/css/navigation"
import {Swiper, SwiperSlide} from 'swiper/react'
import {Autoplay,Navigation} from "swiper/modules"

import AnimateInView from '../../hooks/AnimateInView'

export default function BrandSlider({data}) {
    return <AnimateInView direction="up">
        <section className='container-md mb-5'>
            <Swiper
                spaceBetween={10}
                loop={true}
                pagination={{ clickable: true }}
                speed={400}
                modules={[Autoplay,Navigation]}
                autoplay={{delay: 10000}}
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
                    data.map((brand, i) => <SwiperSlide key={i}>
                            <a href={brand.url} className='d-flex justify-content-center align-items-cente' style={{ height: "10rem" }}>
                                <img src={brand.image} width="100%" className='max-w-15 object-fit-contain' />
                            </a>
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
