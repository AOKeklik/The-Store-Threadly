import React from 'react'
import SectionTitle from './HeadingPrimary'

import img1 from "../../assets/payment/1.webp"
import img2 from "../../assets/payment/2.webp"
import img3 from "../../assets/payment/3.webp"
import img4 from "../../assets/payment/4.webp"
import ProductThirdItem from '../products/ProductThirdItem'

import Subscribe from '../subscribe/Subscribe'

export default function footer() {
    return <div>
        <Subscribe />
        <footer id='section-footer'>
            <div className='container-md'>
                <div className="row gy-5 mb-5">
                    <div className="col-lg-4 col-md-6">
                        <SectionTitle title="CONTACT US" size="small" />
                        <div className='d-flex justify-content-center justify-content-md-start'>
                            <ul className='d-flex flex-column gap-3'>
                                <li className='d-flex gap-2 hover-text-danger'>
                                    <i className="bi bi-geo-alt"></i>
                                    <a href='#'>
                                        28 Green Tower, Street Name, <br />
                                        New York City, USA
                                    </a>
                                </li>
                                <li className='d-flex gap-2 hover-text-danger'>
                                    <i className="bi bi-envelope"></i>
                                    <a href='#'>management@info.com</a> 
                                </li>
                                <li className='d-flex gap-2 hover-text-danger'>
                                    <i className="bi bi-telephone"></i>
                                    <a href="#">+48 444 543 34 54</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div className="col-lg-4 col-md-6 d-flex gap-5 justify-content-center">
                        <div>
                            <SectionTitle title="Accounts" size="small" />
                            <ul className='d-flex flex-column gap-3'>
                                <li className='d-flex gap-2 align-items-center hover-text-danger'>
                                    <i className="bi bi-circle fs-05"></i>
                                    <a href='#'>My Account</a>
                                </li>
                                <li className='d-flex gap-2 align-items-center hover-text-danger'>
                                    <i className="bi bi-circle fs-05"></i>
                                    <a href='#'>My Wishlist</a> 
                                </li>
                                <li className='d-flex gap-2 align-items-center hover-text-danger'>
                                    <i className="bi bi-circle fs-05"></i>
                                    <a href="#">My Cart</a>
                                </li>
                                <li className='d-flex gap-2 align-items-center hover-text-danger'>
                                    <i className="bi bi-circle fs-05"></i>
                                    <a href="#">Sign In</a>
                                </li>
                                <li className='d-flex gap-2 align-items-center hover-text-danger'>
                                    <i className="bi bi-circle fs-05"></i>
                                    <a href="#">Check out</a>
                                </li>
                            </ul>
                        </div>
                        <div>
                            <SectionTitle title="Shipping" size="small" />
                            <ul className='d-flex flex-column gap-3'>
                                <li className='d-flex gap-2 align-items-center hover-text-danger'>
                                    <i className="bi bi-circle fs-05"></i>
                                    <a href='#'>New Products</a>
                                </li>
                                <li className='d-flex gap-2 align-items-center hover-text-danger'>
                                    <i className="bi bi-circle fs-05"></i>
                                    <a href='#'>Top Sellers</a> 
                                </li>
                                <li className='d-flex gap-2 align-items-center hover-text-danger'>
                                    <i className="bi bi-circle fs-05"></i>
                                    <a href="#">Manufactirers</a>
                                </li>
                                <li className='d-flex gap-2 align-items-center hover-text-danger'>
                                    <i className="bi bi-circle fs-05"></i>
                                    <a href="#">Suppliers</a>
                                </li>
                                <li className='d-flex gap-2 align-items-center hover-text-danger'>
                                    <i className="bi bi-circle fs-05"></i>
                                    <a href="#">Specials</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div className="col-lg-4 col-md-6">
                        <SectionTitle title="YOUR CHOICE PRODUCTS" size="small" />
                        <div className='d-flex flex-column flex-sm-row gap-2'>
                            <ProductThirdItem />
                            <ProductThirdItem />
                        </div>
                    </div>
                </div>
                <div className='d-flex justify-content-between'>
                    <span>© AbdullahOnurKeklik 2024. All Rights Reserved.</span>
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
