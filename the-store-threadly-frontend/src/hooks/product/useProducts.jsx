import { useEffect, useState } from 'react'
import { useDispatch, useSelector } from 'react-redux'
import useFilters from './useFilters'
import { fetchAllProducts, fetchFeaturedProducts, fetchFilteredProducts, fetchOneProduct } from '../../redux/productSlice'

export default function useProducts (slug) {
    const dispatch = useDispatch ()
    const { activeFilters } = useFilters ()
    const [page,setPage] = useState(1)

    const {
        productAll,
        productOne,
        productFiltered,
        productFeatured,
    } = useSelector(state => state.product)

    useEffect(() => {
            dispatch(fetchAllProducts())
        }, [dispatch])
    
    useEffect(() => {
        dispatch(fetchFeaturedProducts())
    }, [dispatch])

    useEffect(() => {
        dispatch(fetchFilteredProducts({...activeFilters, page}))
    }, [dispatch,activeFilters,page])

    useEffect(() => {
        if (slug) {
            dispatch(fetchOneProduct(slug))
        }
    }, [dispatch, slug])

    const filtering = (filteredData) => filteredData.filter(product => {
        // Color filter - skip if product doesn't match selected color
        if (activeFilters.color && product.color?.slug !== activeFilters.color) return false

        // Size filter - skip if product doesn't match selected size
        if (activeFilters.size && product.size?.slug !== activeFilters.size) return false

        // Gender filter - skip if product doesn't match selected gender
        if (activeFilters.gender && product.gender !== activeFilters.gender) return false

        // Category filter - skip if product doesn't match selected category
        if (activeFilters.category && product.category.slug !== activeFilters.category) return false

        // Include product if it passed all active filters
        return true
    })

    return {
        productAll,
        productOne,
        productFiltered:{
            ...productFiltered,
            data:filtering(productFiltered.data),
        },
        productFeatured,

        setPage,
    }
}
