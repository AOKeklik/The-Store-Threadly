import React from 'react'
import 'swiper/css/bundle'
import "swiper/css"
import "swiper/css/navigation"
import {Swiper, SwiperSlide} from 'swiper/react'
import {Autoplay,Navigation,Pagination} from "swiper/modules"

import img1 from '../../assets/hero-slider/1.jpg'
import img2 from '../../assets/hero-slider/2.jpg'
import img3 from '../../assets/hero-slider/3.jpg'
import ButtonPrimary from '../buttons/ButtonPrimary'

import BoxFirst from './BoxFirst'
import BoxSecond from './BoxSecond'

export default function HeroSlider() {


    return (
        <div id='section-hero-slider' className='row flex-wrap-reverse'>
            <div className='col-lg-4 mb-5 mb-lg-0'>
                <div className="row">
                    <BoxFirst />
                    <BoxSecond />
                </div>
            </div>
            <div className="col-lg-8 mb-4">
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
                    {/* Slide 1 */}
                    <SwiperSlide className='position-relative'>
                        <img src={img1} alt="" />
                        <div className="position-absolute top-50 end-0 translate-middle-y text-white p-5">
                            <p className='animate__animated animate__fadeInDown m-0'>
                                WELCOME TO OUR TOUR
                            </p>
                            <p className='fs-1 animate__animated animate__fadeInUp lh-1 mb-4'>
                                OUR FASILATING T-SHIRT
                            </p>
                            <ButtonPrimary text="SHOP NOW" />
                        </div>
                    </SwiperSlide>

                    {/* Slide 2 */}
                    <SwiperSlide className='position-relative'>
                        <img src={img2} alt="" />
                        <div className="position-absolute top-50 end-0 translate-middle-y p-5 w-50">
                            <p className='fs-1 animate__animated animate__fadeInDown lh-1'>
                                OUR FASILATING T-SHIRT
                            </p>
                            <p className='animate__animated animate__fadeInUp lh-1 mb-4'>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                            <ButtonPrimary text="SHOP NOW" />
                        </div>
                    </SwiperSlide>

                    {/* Slide 3 */}
                    <SwiperSlide className='position-relative'>
                        <img src={img3} alt="" />
                        <div className="position-absolute top-50 end-0 translate-middle-y text-white p-5">
                            <p className='animate__animated animate__fadeInDown mb-0'>
                                WELCOME TO OUR TOUR
                            </p>
                            <p className='fs-1 animate__animated animate__fadeInUp lh-1 mb-4'>
                                OUR FASILATING T-SHIRT
                            </p>
                            <ButtonPrimary text="SHOP NOW" />
                        </div>
                    </SwiperSlide>

                    {/* Arrows */}
                    <button className="swiper-button-prev-custom rounded-0 rounded-end btn btn-outline-secondary position-absolute top-50 start-0 translate-middle-y z-3 p-1">
                        <i className="bi bi-chevron-left"></i>
                    </button>
                    <button className="swiper-button-next-custom rounded-0 rounded-start btn btn-outline-secondary position-absolute top-50 end-0 translate-middle-y z-3 p-1">
                        <i className="bi bi-chevron-right"></i>
                    </button>
                </Swiper>
            </div>
        </div>
    )
}
