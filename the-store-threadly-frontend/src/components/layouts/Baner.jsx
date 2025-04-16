import React from 'react'
import "./Baner.css"
import { Link } from 'react-router-dom'
import defaultBannerImage from '../../assets/baner/1.jpg';

export default function Baner ({backgroundImage=null,title,breadcrumbs=[],desc}) {
    const getImage = backgroundImage || defaultBannerImage;

    return <div className="position-relative w-100 section-baner mb-5">
        <img src={getImage} alt="banner" className="w-100 h-100 object-fit-cover position-absolute top-0 start-0" />

        {/* Breadcrumb links - bottom left */}
        <div className="position-absolute bottom-0 start-0 p-3 z-2">
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

        {/* Title & Description - center */}
        <div className="position-absolute top-50 start-50 translate-middle text-center z-2">
            <h2 className="text-white fw-bold">{title}</h2>
            {desc && <p className="text-white mt-2">{desc}</p>}
        </div>

        {/* Optional: black overlay for contrast */}
        <div className="position-absolute top-0 start-0 w-100 h-100 bg-dark opacity-50"></div>
    </div>
}