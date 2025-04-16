import React from 'react'
import HeadingPrimary from '../../components/layouts/HeadingPrimary'

import { useDispatch, useSelector } from 'react-redux'
import { setFilter, resetFilters } from '../../redux/filterSlice'

export default function ProductFilter() {
    const dispatch = useDispatch()
    const filters = useSelector(state => state.filters);
    const {
        colors,
        sizes,
        categories,
    } = useSelector(state => state.products);

    return <div className="col-lg-3 col-md-4">
        <div className="row bg-light px-2 py-4">
            <div className="col-12 mb-4">
                <HeadingPrimary title="Category" size="small" />
                <ul className="list-unstyled d-flex flex-wrap justify-content-center gap-2">
                    {categories.map((cat, i) => (
                        <li key={i}>
                            <button
                                type="button"
                                className={`btn btn-outline-secondary fs-08 ${
                                    filters.category === cat.slug ? "btn-dark text-white" : ""
                                }`}
                                onClick={() => dispatch(setFilter({key: "category", value: cat.slug }))}
                            >
                                {cat.name}
                            </button>
                        </li>
                    ))}
                </ul>
            </div>
            <div className="col-12 mb-4">
                <HeadingPrimary title="Gender" size="small" />
                <ul className="list-unstyled d-flex flex-wrap justify-content-center gap-2">
                    {["men", "women", "kids"].map((g, i) => (
                    <li key={i}>
                        <button
                            type="button"
                            className={`btn btn-outline-secondary ${
                                filters.gender === g ? "btn-dark text-white" : ""
                            }`}
                            onClick={() => dispatch(setFilter({key: "gender", value: g }))}
                        >
                        {g.charAt(0).toUpperCase() + g.slice(1)}
                        </button>
                    </li>
                    ))}
                </ul>
            </div>
            <div className="col-12">
                <HeadingPrimary title="Color" size="small" />
                <ul className="list-unstyled d-flex flex-wrap justify-content-center gap-2">
                    {colors.map((color, i) => (
                        <li key={i}>
                            <button 
                                type="button" 
                                className={`border rounded-circle ${filters.color === color.slug ? "border-dark border-2" : ""}`} 
                                style={{
                                    width: "30px", 
                                    height: "30px", 
                                    backgroundColor: color.icon,
                                    border: color.slug === "white" ? "1px solid #ccc" : "none"
                                }}
                                title={color.name}
                                onClick={() => dispatch(setFilter({key: "color", value: color.slug }))}
                            />
                        </li>
                    ))}
                </ul>
            </div>
            <div className="col-12 mb-4">
                <HeadingPrimary title="Size" size="small" />
                <ul className="list-unstyled d-flex flex-wrap justify-content-center gap-2">
                    {sizes.map((size, i) => (
                        <li key={i} className="d-inline-block me-2 mb-2">
                            <button 
                                type="button" 
                                className={`btn btn-outline-secondary rounded-circle d-flex align-items-center justify-content-center ${
                                    filters.size === size.slug ? "btn-dark text-white" : ""
                                }`}
                                style={{
                                    width: "30px", 
                                    height: "30px", 
                                    fontWeight: "bold"
                                }}
                                title={size.name}
                                onClick={() => dispatch(setFilter({key: "size", value: size.slug }))}
                            >
                                {size.icon}
                            </button>
                        </li>
                    ))}
                </ul>
            </div>
            <div className='text-center'>
                <button className='btn btn-danger' onClick={() => dispatch(resetFilters())}>
                    Reset Filter
                </button>
            </div>
        </div>
    </div>
}
