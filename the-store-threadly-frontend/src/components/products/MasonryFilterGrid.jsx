import React, { useState } from 'react'
import "./MasonryFilterGrid.css"

import useFetch from '../hooks/useFetch'
import { URL_PRODUCT } from '../../config'
import Loader from '../loader/Loader'
import ProductItem from './ProductItem'

export default function MasonryFilterGrid() {
    const [data, loading, error ] = useFetch(`${URL_PRODUCT}/all`)
    const [filter, setFilter] = useState("all");

    if(loading) return <Loader />
    
    console.log(data)
    const filteredData = data.data.filter(product => {
        if (filter === "all") return true
        if (filter === "new") return product.is_new
        if (filter === "best") return product.is_best_seller
        if (filter === "discount") return product.offer_price && product.offer_price < product.price
        return true;
    });
    
    return (
        <section id="section-masonry-filter-grid" className="container-md mb-5">
            <div className="filter-buttons">
                <button 
                    onClick={() => setFilter("new")} 
                    className={filter === "new" ? "active" : ""}
                >New Arrivals</button>
                <button 
                    onClick={() => setFilter("best")} 
                    className={filter === "best" ? "active" : ""}
                >Best Seller</button>
                <button
                    onClick={() => setFilter("discount")} 
                    className={filter === "discount" ? "active" : ""}
                >Discounts</button>
                <button 
                    onClick={() => setFilter("all")} 
                    className={filter === "all" ? "active" : ""}
                >All</button>
            </div>

            <div className="masonry-grid">
                {filteredData.map((product, i) => (
                    <div className="masonry-item" key={i}>
                        <ProductItem product={product} />
                    </div>
                ))}
            </div>
        </section>
    )
}

