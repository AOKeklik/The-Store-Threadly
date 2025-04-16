import React from 'react'
import "./Header.css"
import logo from '../../assets/logo.png'
import useScrollFixedHeader from '../hooks/useScrollFixedHeader'
import { Link, NavLink } from 'react-router-dom'

export default function Header() {
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
                    <img className='logo' src={logo} alt="" />
                </Link>
                <a  href='javasicript:void()' className="position-relative">
                    <i className="bi bi-cart-fill"></i>
                     <span className="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger ">
                        3
                    </span>
                </a>
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
                                <NavLink className="nav-link" to="/products">Products</NavLink>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
    </div>
}