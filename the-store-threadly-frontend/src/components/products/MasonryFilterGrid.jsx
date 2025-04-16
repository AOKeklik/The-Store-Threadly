import React, { useState } from 'react'
import "./MasonryFilterGrid.css"

import ProductPrymaryItem from './ProductPrymaryItem'
import AnimateInView from '../hooks/AnimateInView'

export default function MasonryFilterGrid({data}) {
    const [filter, setFilter] = useState("all");

    const filteredData = data.filter(product => {
        if (filter === "all") return true
        if (filter === "new") return product.is_new
        if (filter === "best") return product.is_best_seller
        if (filter === "discount") return product.offer_price && product.offer_price < product.price
        return true;
    });
    
    return (
        <section id="section-masonry-filter-grid" className="container-md mb-5">
            <AnimateInView className="filter-buttons">
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
            </AnimateInView>

            <div className="masonry-grid">
                {filteredData.map((product, i) => (
                    <div className="masonry-item" key={i}>
                        <AnimateInView direction="up">
                            <ProductPrymaryItem product={product} />
		                </AnimateInView>
                    </div>
                ))}
            </div>
        </section>
    )
}

