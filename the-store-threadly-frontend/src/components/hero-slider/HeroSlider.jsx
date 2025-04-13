import React from 'react'
import "./heroSlider.css"
import 'swiper/css/bundle'
import {Swiper, SwiperSlide} from 'swiper/react'
import {Autoplay,Navigation,Pagination} from "swiper/modules"

import img1 from '../../assets/hero-slider/1.jpg'
import img2 from '../../assets/hero-slider/2.jpg'
import img3 from '../../assets/hero-slider/3.jpg'
import ButtonSlider from '../buttons/ButtonSlider'

export default function HeroSlider() {
    return (
        <div id='hero-slider-section' className='row'>
            <div className='col-lg-4 p-5'>
                <div className="row">
                    <div className="col-lg-12 col-md-6 mb-3">
                        <div className="card">
                            <div className="card-body">
                                <h5 className="card-title">Special title treatment</h5>
                                <p className="card-text">With supporting text below as a natural lead-in to additional content.</p>
                                <a href="#" className="btn btn-primary">Go somewhere</a>
                            </div>
                        </div>
                    </div>
                    <div className="col-lg-12 col-md-6">
                        <div className="card">
                            <div className="card-body">
                                <h5 className="card-title">Special title treatment</h5>
                                <p className="card-text">With supporting text below as a natural lead-in to additional content.</p>
                                <a href="#" className="btn btn-primary">Go somewhere</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div className="col-lg-8">
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
                >
                    {/* Slide 1 */}
                    <SwiperSlide className='position-relative'>
                        <img src={img1} alt="" />
                        <div className="position-absolute top-50 start-50 text-white">
                            <p className='animate__animated animate__fadeInDown lh-1'>
                                WELCOME TO OUR TOUR
                            </p>
                            <p className='fs-1 animate__animated animate__fadeInUp lh-1'>
                                OUR FASILATING T-SHIRT
                            </p>
                            <ButtonSlider text="SHOP NOW" />
                        </div>
                    </SwiperSlide>

                    {/* Slide 2 */}
                    <SwiperSlide className='position-relative'>
                        <img src={img2} alt="" />
                        <div className="position-absolute top-50 start-50">
                            <p className='fs-1 animate__animated animate__fadeInDown lh-1'>
                                OUR FASILATING T-SHIRT
                            </p>
                            <p className='animate__animated animate__fadeInUp lh-1'>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                            <ButtonSlider text="SHOP NOW" />
                        </div>
                    </SwiperSlide>

                    {/* Slide 3 */}
                    <SwiperSlide className='position-relative'>
                        <img src={img3} alt="" />
                        <div className="position-absolute top-50 start-50 text-white">
                            <p className='animate__animated animate__fadeInDown lh-1'>
                                WELCOME TO OUR TOUR
                            </p>
                            <p className='fs-1 animate__animated animate__fadeInUp lh-1'>
                                OUR FASILATING T-SHIRT
                            </p>
                            <ButtonSlider text="SHOP NOW" />
                        </div>
                    </SwiperSlide>
                </Swiper>
            </div>
        </div>
    )
}
