import React from 'react'

import 'swiper/css/bundle'
import {Swiper, SwiperSlide} from 'swiper/react'
import {Autoplay,Navigation,Pagination} from "swiper/modules"

import img1 from '../../assets/discount-slider/1.jpg'
import img2 from '../../assets/discount-slider/2.jpg'
import img3 from '../../assets/discount-slider/3.jpg'
import ButtonPrimary from '../buttons/ButtonPrimary'

import AnimateInView from "../hooks/AnimateInView"

export default function DiscountProducts() {

    return <AnimateInView direction='up'>
        <section id="section-discount-products" className='container-md mb-5'>
            <Swiper
                spaceBetween={16}
                slidesPerView={1} 
                loop={true}
                pagination={{ clickable: true }}
                speed={3000}
                modules={[Pagination,Autoplay,Navigation]}
                className='h-full relative lg:mt-10 mt-7'
                autoplay={{delay: 8000}}
            >
                {/* Item */}
                <SwiperSlide className='position-relative'>
                    <img src={img1} alt="" />
                    <div className="position-absolute top-50 end-0 translate-middle-y text-white p-5">
                        <p className='sale position-absolute top-0 end-0 bg-danger rounded-circle d-flex justify-content-center align-content-center flex-column text-center translate-middle'>
                            <span>On Sale</span>
                            <span></span>
                            <span className='fw-bold'>69.99 PLN</span>
                        </p>
                        <p className='animate__animated animate__fadeInDown m-0 fs-1 text-danger fw-bold'>
                            DISCOUNT 50%
                        </p>
                        <p className='animate__animated animate__fadeInUp lh-1 mb-4 w-75 fs-5'>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. 
                        </p>
                        <ButtonPrimary text="BUY NOW" size='small' fill="primary" />
                    </div>
                </SwiperSlide>

                {/* Item */}
                <SwiperSlide className='position-relative'>
                    <img src={img2} alt="" />
                    <div className="position-absolute top-50 end-0 translate-middle-y text-white p-5">
                        <p className='sale position-absolute top-0 end-0 bg-danger rounded-circle d-flex justify-content-center align-content-center flex-column text-center translate-middle'>
                            <span>On Sale</span>
                            <span></span>
                            <span className='fw-bold'>69.99 PLN</span>
                        </p>
                        <p className='animate__animated animate__fadeInDown m-0 fs-1 text-danger fw-bold'>
                            DISCOUNT 50%
                        </p>
                        <p className='animate__animated animate__fadeInUp lh-1 mb-4 w-75 fs-5'>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. 
                        </p>
                        <ButtonPrimary text="BUY NOW" size='small' fill="primary" />
                    </div>
                </SwiperSlide>

                {/* Item */}
                <SwiperSlide className='position-relative'>
                    <img src={img3} alt="" />
                    <div className="position-absolute top-50 end-0 translate-middle-y p-5">
                        <p className='sale position-absolute top-0 end-0 bg-danger rounded-circle d-flex justify-content-center align-content-center flex-column text-center translate-middle text-white'>
                            <span>On Sale</span>
                            <span></span>
                            <span className='fw-bold'>69.99 PLN</span>
                        </p>
                        <p className='animate__animated animate__fadeInDown m-0 fs-1 text-danger fw-bold'>
                            DISCOUNT 50%
                        </p>
                        <p className='animate__animated animate__fadeInUp lh-1 mb-4 w-75 fs-5'>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. 
                        </p>
                        <ButtonPrimary text="BUY NOW" size='small' fill="primary" />
                    </div>
                </SwiperSlide>
            </Swiper> 
        </section>
    </AnimateInView>
}