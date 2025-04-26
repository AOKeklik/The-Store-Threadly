import React from 'react'
import "./Header.css"
import useScrollFixedHeader from '../../hooks/useScrollFixedHeader'
import { Link, NavLink } from 'react-router-dom'

import { useSettings } from '../../context/settingContext'
import DisplayCartPopover from '../../displays/DisplayCartPopover'
import useWishlist from '../../hooks/useWishlist'

export default function Header() {
    const { wishlistCount, isWishlistEmpty } = useWishlist();
    const { settings } = useSettings()
    const fixedHeader = useScrollFixedHeader()

    return <div id='section-header-wrapper'>
        <nav
            id='section-header' 
            className={`${fixedHeader ? 'fixed' : ''} navbar`}
        >
            <div className="container">
                <button className="btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasMenu" aria-controls="offcanvasMenu">
                    <i className="bi bi-list"></i>
                </button>
                <Link to="/" className="navbar-brand">
                    <img className='logo' src={settings.site_logo_url} alt="" />
                </Link>
                <div className='d-flex align-items-center gap-3'>
                    {/* ///////////// WISHLIST ///////////// */}
                    <Link to="/wishlist"  className="position-relative text-secondary hover-text-gray-800">
                        {
                            isWishlistEmpty() ? (
                                <i className="bi bi-heart"></i>
                            ) : (
                                <i className="bi bi-heart-fill"></i>
                            )
                        }
                        <span className="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            {wishlistCount}
                        </span>
                    </Link>
                    {/* ///////////// WISHLIST ///////////// */}

                    {/* ///////////// CART ///////////// */}
                    <DisplayCartPopover />
                    {/* ///////////// CART ///////////// */}

                    {/* ///////////// login ///////////// */}
                    <Link to="/signin"  className="text-secondary hover-text-gray-800">
                        <i className="bi bi-person-fill fs-4"></i>
                    </Link>
                    {/* ///////////// login ///////////// */}
                </div>
                <div className="offcanvas offcanvas-start" tabIndex="-1" id="offcanvasMenu" aria-labelledby="offcanvasMenuLabel">
                    <div className="offcanvas-header">
                        <button type="button" className="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div className="offcanvas-body">
                        <ul className="navbar-nav">
                            <li className="nav-item">
                                <NavLink className="nav-link" to="/">Home</NavLink>
                            </li>
                            <li className="nav-item">
                                <NavLink className="nav-link" to="/about">About</NavLink>
                            </li>
                            <li className="nav-item">
                                <NavLink className="nav-link" to="/products">Products</NavLink>
                            </li>
                            <li className="nav-item">
                                <NavLink className="nav-link" to="/blogs">Blogs</NavLink>
                            </li>
                            <li className="nav-item">
                                <NavLink className="nav-link" to="/contact">Contact</NavLink>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
    </div>
}