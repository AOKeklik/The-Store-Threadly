import React from 'react'
import logo from '../../assets/logo.png'
import useScrollFixedHeader from '../hooks/useScrollFixedHeader'

export default function Header() {
    const fixedHeader = useScrollFixedHeader()   

    return <>
        <nav
            id='section-header' 
            className={`${fixedHeader ? 'fixed' : ''} navbar bg-body-tertiary`}
        >
            <div className="container">
                <button className="btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasMenu" aria-controls="offcanvasMenu">
                    <i class="bi bi-list"></i>
                </button>
                <a className="navbar-brand" href="#">
                    <img className='logo' src={logo} alt="" />
                </a>
                <a  href='javasicript:void()' className="position-relative">
                    <i className="bi bi-cart-fill"></i>
                     <span className="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger ">
                        3
                    </span>
                </a>
                <div className="offcanvas offcanvas-start" tabIndex="-1" id="offcanvasMenu" aria-labelledby="offcanvasMenuLabel">
                    <div class="offcanvas-header">
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div className="offcanvas-body">
                        <ul className="navbar-nav">
                        <li className="nav-item">
                            <a className="nav-link active" href="#">Home</a>
                        </li>
                        <li className="nav-item">
                            <a className="nav-link" href="#">Shirt</a>
                        </li>
                        <li className="nav-item">
                            <a className="nav-link" href="#">T-Shirt</a>
                        </li>
                        <li className="nav-item">
                            <a className="nav-link" href="#">Contact</a>
                        </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
    </>
}