import React from 'react'
import "./Baner.css"
import { Link } from 'react-router-dom'
import defaultBannerImage from '../../assets/baner/1.jpg';

export default function Baner ({cover=null,title,breadcrumbs=[],desc}) {
    const getImage = cover || defaultBannerImage;

    return <div id='section-baner' className="mb-5 position-relative">
        <img src={getImage} alt="banner" className="w-100 h-100 object-fit-cover" />

        <div className="container-lg w-100 h-100 position-relative position-absolute bottom-0 start-50 translate-middle-x z-2">
            {/* Title & Description - center */}
            <div className="position-absolute top-50 start-50 translate-middle text-center">
                <h2 className="text-white fw-bold">{title}</h2>
                {desc && <p className="text-white mt-2">{desc}</p>}
            </div>

            {/* Breadcrumb links - bottom left */}
            <div className="position-absolute bottom-0 start-0 p-3">
                <div className="d-flex align-items-center flex-wrap gap-2 text-white small">
                    <Link className="text-white hover-text-danger" to="/">Home</Link>
                    <i className="bi bi-chevron-right text-white"></i>
                    {breadcrumbs.map(({path, label}, i) => {
                        const isLast = i === breadcrumbs.length - 1;
                        return isLast ? (
                            <span key={i} className="text-white">{label}</span>
                        ) : (
                            <React.Fragment key={i}>
                                <Link className="text-white hover-text-danger" to={path}>{label}</Link>
                                <i className="bi bi-chevron-right text-white"></i>
                            </React.Fragment>
                        );
                    })}
                </div>
            </div>
        </div>

        {/* Optional: black overlay for contrast */}
        <div className="position-absolute top-0 start-0 w-100 h-100 bg-dark opacity-50 z-1"></div>
    </div>
}