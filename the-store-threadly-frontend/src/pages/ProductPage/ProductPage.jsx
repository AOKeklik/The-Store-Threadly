import React, { useEffect } from 'react'
import Baner from '../../components/layouts/Baner'


import { useDispatch, useSelector } from 'react-redux'
import { fetchAllProducts, fetchFilteredProducts } from '../../redux/productsSlice'
import { resetFilters } from '../../redux/filterSlice'
import Loader from '../../components/layouts/Loader'
import ProductFilter from './ProductFilter'
import ProductItem from './ProductItem'

export default function ProductPage() {
    const dispatch = useDispatch()
    const filters = useSelector(state => state.filters);
    const {
        filteredData,
        loading,
        loadingFiltered,
    } = useSelector(state => state.products)

    useEffect(() => {
        dispatch(fetchAllProducts())
    }, [dispatch])

    useEffect(() => {
        dispatch(fetchFilteredProducts(filters))
    }, [dispatch,filters])


    if(loading) return <Loader />

    return <>
        <Baner {...{
            title: "Our Products",
            links: [{path: "",label:"Our Services"}],
        }} />

        <main className='container-xl mb-5'>
            <div className="row g-5 flex-column-reverse flex-md-row">
                <div className="col-lg-9 col-md-8">
                    <div className='row g-3'>
                        {
                            loadingFiltered ? (
                                <Loader fullHeight={false} />
                            ): (
                                filteredData?.data?.length === 0 ? (
                                    <div className="alert alert-warning text-center w-100 d-flex flex-column align-items-center" role="alert">
                                        <i className="bi bi-exclamation-triangle fs-3 mb-2"></i>
                                        <strong>No matching products found.</strong><br />
                                        Try adjusting your filters or
                                        <button className="btn btn-link p-0 ms-1" onClick={() => dispatch(resetFilters())}>view all products</button>.
                                    </div>
                                ):(
                                    <ProductItem />
                                )
                            )
                        }
                    </div>
                </div>
                <ProductFilter />
            </div>
        </main>
    </>
}
