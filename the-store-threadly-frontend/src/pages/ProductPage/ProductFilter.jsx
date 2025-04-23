import React from 'react'
import HeadingPrimary from '../../components/layouts/HeadingPrimary'

import useFilters from '../../hooks/useFilters'
import { useSettings } from '../../context/settingContext'

export default function ProductFilter() {
    const {colors, sizes, productCategories} = useSettings()

/* ///////// FILTER ///////// */
    const {
        toggleFilter,
        isFilterActive,
        clearAllFilters,
    } = useFilters()
/* ///////// FILTER ///////// */


    return <div className="col-lg-3 col-md-4">
        <div className="row bg-light px-2 py-4">
            {/* /////////////// CATEGORY FILTER /////////////// */}
            <div className="col-12 mb-4">
                <HeadingPrimary title="Category" size="small" />
                <ul className="list-unstyled d-flex flex-wrap justify-content-center gap-2">
                    {productCategories.map((cat, i) => (
                        <li key={i}>
                            <button
                                type="button"
                                className={`btn btn-outline-secondary fs-08 ${
                                    isFilterActive("category",cat.slug) ? "btn-dark text-white" : ""
                                }`}
                                onClick={() => toggleFilter("category",cat.slug)}
                            >
                                {cat.name}
                            </button>
                        </li>
                    ))}
                </ul>
            </div>
            {/* /////////////// CATEGORY FILTER /////////////// */}

            {/* /////////////// GENDER FILTER /////////////// */}
            <div className="col-12 mb-4">
                <HeadingPrimary title="Gender" size="small" />
                <ul className="list-unstyled d-flex flex-wrap justify-content-center gap-2">
                    {["men", "women", "kids"].map((g, i) => (
                    <li key={i}>
                        <button
                            type="button"
                            className={`btn btn-outline-secondary ${
                                isFilterActive("gender",g) ? "btn-dark text-white" : ""
                            }`}
                            onClick={() => toggleFilter("gender",g)}
                        >
                        {g.charAt(0).toUpperCase() + g.slice(1)}
                        </button>
                    </li>
                    ))}
                </ul>
            </div>
            {/* /////////////// GENDER FILTER /////////////// */}

            {/* /////////////// COLOR FILTER /////////////// */}
            <div className="col-12">
                <HeadingPrimary title="Color" size="small" />
                <ul className="list-unstyled d-flex flex-wrap justify-content-center gap-2">
                    {colors.map((color, i) => (
                        <li key={i}>
                            <button 
                                type="button" 
                                className={`border rounded-3 ${isFilterActive("color",color.slug) ? "border-dark border-2" : ""}`} 
                                style={{
                                    width: "25px", 
                                    height: "25px", 
                                    backgroundColor: color.icon,
                                    border: color.slug === "white" ? "1px solid #ccc" : "none"
                                }}
                                title={color.name}
                                onClick={() => toggleFilter("color",color.slug)}
                            />
                        </li>
                    ))}
                </ul>
            </div>
            {/* /////////////// COLOR FILTER /////////////// */}

            {/* /////////////// SIZE FILTER /////////////// */}
            <div className="col-12 mb-4">
                <HeadingPrimary title="Size" size="small" />
                <ul className="list-unstyled d-flex flex-wrap justify-content-center gap-1">
                    {sizes.map((size, i) => (
                        <li key={i} className="d-inline-block me-2 mb-2">
                            <button 
                                type="button" 
                                className={`btn btn-outline-secondary rounded-3 d-flex align-items-center justify-content-center text-uppercase px-2 py-0 ${
                                    isFilterActive("size",size.slug) ? "btn-dark text-white" : ""
                                }`}
                                title={size.name}
                                onClick={() => toggleFilter("size",size.slug)}
                            >
                                {size.icon}
                            </button>
                        </li>
                    ))}
                </ul>
            </div>
            {/* /////////////// SIZE FILTER /////////////// */}

            {/* /////////////// RESET FILTER /////////////// */}
            <div className='text-center'>
                <button className='btn btn-danger' onClick={clearAllFilters}>
                    Reset Filter
                </button>
            </div>
        </div>
    </div>
}
