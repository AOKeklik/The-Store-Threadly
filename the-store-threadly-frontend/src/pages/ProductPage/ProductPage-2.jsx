import React, { useState, useEffect } from 'react'
import Baner from '../../components/baner/Baner'

import useFetch from '../../components/hooks/useFetch'
import { URL_PRODUCT } from '../../config'
import Loader from '../../components/loader/Loader'

import img from "../../assets/baner/1.jpg"
import HeadingPrimary from '../../components/headins/HeadingPrimary'

export default function ProductPage() {
    const [{data,colors,sizes,categories}, loading, error ] = useFetch(`${URL_PRODUCT}/all`)

    /* /// FILTER /// */
    const [loadingFiltered, setLoadingFiltered] = useState(false);
    const [filters, setFilters] = useState({ color: "", size: "",  gender: "", category: "" });
    const [products, setProducts] = useState([]);
    useEffect(() => {
        const fetchFilteredProducts = async () => {
            setLoadingFiltered(true)
            try {
                const query = new URLSearchParams()
                if (filters.color) query.append("color", filters.color)
                if (filters.size) query.append("size", filters.size)
                if (filters.gender) query.append("gender", filters.gender)
                if (filters.category) query.append("category", filters.category)
    
                const res = await fetch(`${URL_PRODUCT}/filter?${query.toString()}`)
                const result = await res.json()
                setProducts(result)
            } catch (err) {
                console.error("Filtering failed", err)
            } finally {
                setLoadingFiltered(false)
            }
        };
    
        fetchFilteredProducts()
    }, [filters])

    const getMatchingVariant = (product, filters) => {
        return product.variants?.find(variant => {
            const colorMatch = !filters.color || variant.attributes?.some(attr =>
                attr.attribute.slug === "color" && attr.slug === filters.color
            )
            const sizeMatch = !filters.size || variant.attributes?.some(attr =>
                attr.attribute.slug === "size" && attr.slug === filters.size
            )
            return colorMatch && sizeMatch
        })
    }

console.log(filters)

    if(loading) return <Loader />


    return <>
        <Baner {...{
            img,
            title: "Our Products",
            links: [{key: "",val:"Our Services"}],
        }} />

        <main className='container-xl mb-5'>
            <div className="row g-5 flex-column-reverse flex-md-row">
                <div className="col-lg-9 col-md-8">
                    <div className='row g-3'>
                        {
                            loadingFiltered ? (
                                <Loader fullHeight={false} />
                            ) : (
                                products.data.map((product, i) => {
                                    const isFiltered = Object.values(filters).some(val => val)
                                    const selectedVariant = isFiltered ? getMatchingVariant(product, filters) : null
                                    const thumbnail = isFiltered && selectedVariant?.thumbnail ? selectedVariant.thumbnail : product.thumbnail
                                    const price = isFiltered && selectedVariant?.price_html ? selectedVariant.price_html : product.price_html
                                
                                
                                    return (
                                        <div className='col-lg-4 col-md-6' key={i}>
                                            <div className="section-product-item">
                                                <div className="card border-light-subtle">
                                                    <div className="card-body p-0 position-relative">
                                                        <div className='position-absolute d-flex flex-column gap-2 p-2'>
                                                            {product.is_new > 0 && <span className="badge p-2 bg-warning">New</span>}
                                                            {product.offer_price && <span className="badge p-2 bg-danger">Sale</span>}
                                                        </div>
                                                        <img className='w-100' src={thumbnail} alt={product.title} />
                                                        <div className="icon-box-container d-flex justify-content-center shadow-lg">
                                                            <div className="icon-box bg-white rounded shadow-sm px-3 py-2 d-flex gap-4">
                                                                <i className="bi bi-heart icon-hover"></i>
                                                                <i className="bi bi-eye icon-hover"></i>
                                                                <i className="bi bi-box-arrow-up-right icon-hover"></i>
                                                                <i className="bi bi-cart icon-hover"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div className="card-footer p-3 border-0 ">
                                                        <div className='d-flex justify-content-between mb-1'>
                                                            <h3 className='fs-6 p-0 m-0'>{product.title}</h3>
                                                            <small>{product.category_name}</small>
                                                        </div>
                                                        <div className='d-flex justify-content-between'>
                                                            <h3 className='fs-6 p-0 m-0 text-danger' dangerouslySetInnerHTML={{ __html: price }} />
                                                            <div>
                                                                <i className="bi bi-star-fill"></i>
                                                                <i className="bi bi-star-fill"></i>
                                                                <i className="bi bi-star-fill"></i>
                                                                <i className="bi bi-star-half"></i>
                                                                <i className="bi bi-star"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    )
                                })
                            )
                        }
                    </div>
                </div>
                <div className="col-lg-3 col-md-4">
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
                                            onClick={() => setFilters(prev => ({ ...prev, category: cat.slug }))}
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
                                        onClick={() => setFilters((prev) => ({ ...prev, gender: g }))}
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
                                            onClick={() => setFilters(prev => ({ ...prev, color: color.slug }))}
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
                                            onClick={() => setFilters(prev => ({ ...prev, size: size.slug }))}
                                        >
                                            {size.icon}
                                        </button>
                                    </li>
                                ))}
                            </ul>
                        </div>
                        <div className='text-center'>
                            <button className='btn btn-danger' onClick={() => setFilters({ color: "", size: "", gender: "", category: "" })}>
                                Reset Filter
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </>
}
