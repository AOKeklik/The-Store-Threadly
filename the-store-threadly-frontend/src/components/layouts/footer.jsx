import React from 'react'
import SectionTitle from './HeadingPrimary'

import img1 from "../../assets/payment/1.webp"
import img2 from "../../assets/payment/2.webp"
import img3 from "../../assets/payment/3.webp"
import img4 from "../../assets/payment/4.webp"

import SubscriberForm from '../../form/SubscriberForm'
import { useSettings } from '../../context/settingContext'
import { Link, useLocation } from 'react-router-dom'

export default function Footer() {
    const location = useLocation();
    const { settings } = useSettings()

    return <div>
        <SubscriberForm />
        <footer id='section-footer'>
            <div className='container-md'>
                <div className="row gy-5 mb-5">
                    {/* /////////// CONTACT /////////// */}
                    <div className="col-lg-3 col-md-6">
                        <SectionTitle title="CONTACT US" size="small" classname="mb-3" />
                        <div className='d-flex justify-content-center justify-content-md-start'>
                            <ul className='d-flex flex-column gap-3'>
                                <li className='d-flex gap-2 hover-text-danger'>
                                    <i className="bi bi-geo-alt"></i>
                                    <a href='#'>
                                        <div dangerouslySetInnerHTML={{ __html: settings.site_address }} />
                                    </a>
                                </li>
                                <li className='d-flex gap-2 hover-text-danger'>
                                    <i className="bi bi-envelope"></i>
                                    <a href='#'>{settings.site_email}</a> 
                                </li>
                                <li className='d-flex gap-2 hover-text-danger'>
                                    <i className="bi bi-telephone"></i>
                                    <a href="#">{settings.site_phone}</a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    {/* /////////// ACCOUNT /////////// */}
                    <div className="col-lg-3 col-md-6">
                        <SectionTitle title="Accounts" size="small" classname="mb-3" />
                        <ul className='d-flex flex-column gap-3'>
                            <li className='d-flex gap-2 align-items-center hover-text-danger'>
                                <i className="bi bi-circle fs-05"></i>
                                <Link 
                                    to='/dashboard'
                                    className={location.pathname.startsWith('/dashboard') ? 'active' : ''}
                                >My Account</Link>
                            </li>
                            <li className='d-flex gap-2 align-items-center hover-text-danger'>
                                <i className="bi bi-circle fs-05"></i>
                                <Link 
                                    to='/wishlist'
                                    className={location.pathname.startsWith('/wishlist') ? 'active' : ''}
                                >My Wishlist</Link>
                            </li>
                            <li className='d-flex gap-2 align-items-center hover-text-danger'>
                                <i className="bi bi-circle fs-05"></i>
                                <Link 
                                    to='/cart'
                                    className={location.pathname.startsWith('/cart') ? 'active' : ''}
                                >My Cart</Link>
                            </li>
                            <li className='d-flex gap-2 align-items-center hover-text-danger'>
                                <i className="bi bi-circle fs-05"></i>
                                <Link 
                                    to='/signin'
                                    className={location.pathname.startsWith('/signin') ? 'active' : ''}
                                >Sign In</Link>
                            </li>
                            <li className='d-flex gap-2 align-items-center hover-text-danger'>
                                <i className="bi bi-circle fs-05"></i>
                                <a href="#">Check out</a>
                            </li>
                        </ul>
                    </div>

                    {/* /////////// LEGAL  /////////// */}
                    <div className="col-lg-3 col-md-6">
                        <SectionTitle title="LEGAL" size="small" classname="mb-3" />
                        <ul className='d-flex flex-column gap-3'>
                            <li className='d-flex gap-2 align-items-center hover-text-danger'>
                                <i className="bi bi-circle fs-05"></i>
                                <Link 
                                    to='/terms'
                                    className={location.pathname.startsWith('/terms') ? 'active' : ''}
                                >Terms & Conditions</Link>
                            </li>
                            <li className='d-flex gap-2 align-items-center hover-text-danger'>
                                <i className="bi bi-circle fs-05"></i>
                                <Link 
                                    to='/privacy'
                                    className={location.pathname.startsWith('/privacy') ? 'active' : ''}
                                >Privacy Policy</Link>
                            </li>
                            <li className='d-flex gap-2 align-items-center hover-text-danger'>
                                <i className="bi bi-circle fs-05"></i>
                                <Link 
                                    to='/cookies'
                                    className={location.pathname.startsWith('/cookies') ? 'active' : ''}
                                >Cookie Policy</Link>
                            </li>
                            <li className='d-flex gap-2 align-items-center hover-text-danger'>
                                <i className="bi bi-circle fs-05"></i>
                                <Link 
                                    to='/refunds' 
                                    className={location.pathname.startsWith('/refunds') ? 'active' : ''}
                                >Refund Policy</Link>
                            </li>
                        </ul>
                    </div>

                    {/* /////////// MAP /////////// */}
                    <div className="col-lg-3 col-md-6">
                        <SectionTitle title="Find Us Easily on Google Maps" size="small" classname="mb-3" />
                        <div className='d-flex justify-content-center' dangerouslySetInnerHTML={{ __html: settings.site_map }} />
                    </div>
                </div>

                <div className='d-flex justify-content-between'>
                    {/* /////////// COPY /////////// */}
                    <span>{settings.site_copy}</span>

                    {/* /////////// CARD ICONS /////////// */}
                    <div className='d-flex gap-2'>
                        <img src={img1} alt="" />
                        <img src={img2} alt="" />
                        <img src={img3} alt="" />
                        <img src={img4} alt="" />
                    </div>
                </div>
            </div>
        </footer>
    </div>
}
