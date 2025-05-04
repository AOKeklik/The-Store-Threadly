import React from 'react'
import Baner from '../../components/layouts/Baner'

import Loader from '../../components/layouts/Loader'
import ProductFilter from './ProductFilter'
import ProductItem from './ProductItem'
import useProducts from '../../hooks/product/useProducts'
import useFilters from '../../hooks/product/useFilters'

export default function ProductPage() {
    const { clearAllFilters } = useFilters();
    const {
        productFiltered: {
            data,
            meta,
            loading,
        },

        setPage,
    } = useProducts();

    return <>
        <Baner {...{
            title: "Our Products",
            breadcrumbs: [{path: "",label:"Products"}],
        }} />

        <main className='container-xl mb-5'>
            <div className="row g-5 flex-column-reverse flex-md-row">
                <div className="col-lg-9 col-md-8">
                    {
                        loading ? (
                            <Loader fullHeight={false} />
                        ): (
                            data.length === 0 ? (
                                <div className="alert alert-warning text-center w-100 d-flex flex-column align-items-center" role="alert">
                                    <i className="bi bi-exclamation-triangle fs-3 mb-2"></i>
                                    <strong>No matching products found.</strong><br />
                                    Try adjusting your filters or
                                    <button className="btn btn-link p-0 ms-1" onClick={clearAllFilters}>view all products</button>.
                                </div>
                            ):(
                                <>
                                    <div className='row g-3'>
                                        {
                                             data.map((product) => (
                                                <ProductItem 
                                                    key={`${product.productId}-${product.variantId || 'base'}`}
                                                    product={product}
                                                />
                                            ))
                                        }
                                        {
                                            meta.last_page > 1 && (
                                                <div className="d-flex justify-content-center mt-4">
                                                    <ul className="pagination ">
                                                        {Array.from({ length: meta?.last_page || 1 }).map((_, i) => {
                                                            const pageNum = i + 1
                                                            const isActive = pageNum === meta.current_page
                                                            return (
                                                                <li key={pageNum} className={`page-item ${pageNum === meta?.current_page ? 'active' : ''}`}>
                                                                    <button
                                                                        className={`page-link ${isActive ? 'bg-danger border-danger text-white' : 'text-danger'}`}
                                                                        onClick={() => setPage(pageNum)}
                                                                    >
                                                                        {pageNum}
                                                                    </button>
                                                                </li>
                                                            );
                                                        })}
                                                    </ul>
                                                </div>
                                            )
                                        }
                                    </div>
                                </>
                            )
                        )
                    }
                </div>
                <ProductFilter />
            </div>
        </main>
    </>
}
