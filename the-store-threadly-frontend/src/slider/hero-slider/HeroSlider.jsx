import React from 'react'
import 'swiper/css/bundle'
import "swiper/css"
import "swiper/css/navigation"
import {Swiper, SwiperSlide} from 'swiper/react'
import {Autoplay,Navigation,Pagination} from "swiper/modules"

import ButtonPrimary from '../../buttons/ButtonPrimary'
import AnimateInView from '../../hooks/AnimateInView'
import ProductSecondaryItem from '../../components/products/ProductSecondaryItem'

export default function HeroSlider({products, sliders}) {

    return (
        <div id='section-hero-slider' className='container-fluid'>
            <section className='row flex-wrap-reverse mb-5'>
                <div className='col-lg-3 mb-lg-0'>
                    <div className="row">
                        {
                            products.filter(e => e.is_new).slice(0,2).map((product,i) => (
                                <React.Fragment key={i}>
                                    <AnimateInView className="col-lg-12 col-md-6 mb-lg-3" direction="up">
                                        <ProductSecondaryItem product={product} />
                                    </AnimateInView>
                                </React.Fragment>
                            ))
                        }
                    </div>
                </div>
                <div className="col-lg-9 mb-4">
                    <Swiper
                        spaceBetween={16}
                        slidesPerView={1}
                        loop={true}
                        pagination={{ clickable: true }}
                        speed={400}
                        modules={[Pagination, Autoplay, Navigation]}
                        className='h-full relative lg:mt-10 mt-7'
                        autoplay={{
                            delay: 4000
                        }}

                        navigation={{
                            nextEl: '.swiper-button-next-custom',
                            prevEl: '.swiper-button-prev-custom',
                        }}
                    >
                        {/* Slides */}
                        {
                            sliders.map((slider, i) => (
                                <SwiperSlide className='position-relative' key={i}>
                                    <img src={slider.image} alt="" />
                                    <div className="position-absolute top-50 start-0 translate-middle-y p-5">
                                        <p className='animate__animated animate__fadeInDown m-0'>
                                            WELCOME TO OUR TOUR
                                        </p>
                                        <p className='fs-1 animate__animated animate__fadeInUp lh-1 mb-4 text-danger'>
                                            OUR FASILATING T-SHIRT
                                        </p>
                                        <ButtonPrimary text="SHOP NOW" />
                                    </div>
                                </SwiperSlide>
                            ))
                        }                        

                        {/* Arrows */}
                        <button className="swiper-button-prev-custom rounded-0 rounded-end btn btn-outline-secondary position-absolute top-50 start-0 translate-middle-y z-3 p-1">
                            <i className="bi bi-chevron-left"></i>
                        </button>
                        <button className="swiper-button-next-custom rounded-0 rounded-start btn btn-outline-secondary position-absolute top-50 end-0 translate-middle-y z-3 p-1">
                            <i className="bi bi-chevron-right"></i>
                        </button>
                    </Swiper>
                </div>
            </section>
        </div>
    )
}
