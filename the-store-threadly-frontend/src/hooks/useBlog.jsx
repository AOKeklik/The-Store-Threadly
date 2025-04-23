import { useEffect, useState } from 'react'
import { useDispatch, useSelector } from 'react-redux'
import { fetchAllBlogs, fetchFilteredBlogs, fetchOneBlog } from '../redux/blogSlice'
import Filter from './useBlogFilter'

export default function useBlog(slug) {
    const dispatch = useDispatch()
    const [page, setPage] = useState(1)

    const {
        dataAllBlog,
        loadingAllBlog,

        dataBlog,
        dataRelatedBlog,
        loadingBlog,
        
        dataFilteredBlog,
        metaFilteredBlog,
        loadingFilteredBlog,
    } = useSelector(state => state.blog)

    const { 
        selectedCategory, 
        handleCategorySelect, 
        resetFilters 
    } = Filter(dataFilteredBlog)

    useEffect(() => {
        dispatch(fetchAllBlogs())
    }, [dispatch])
    
    useEffect(() => {
        dispatch(fetchFilteredBlogs({ category: selectedCategory, page }))
    }, [dispatch,selectedCategory,page])

    useEffect(() => {
        if(slug) {
            dispatch(fetchOneBlog(slug))
        }
    }, [dispatch, slug])


    return {
        dataAllBlog,
        loadingAllBlog,

        dataBlog,
        dataRelatedBlog,
        loadingBlog,

        dataFilteredBlog,
        metaFilteredBlog,
        loadingFilteredBlog,

        selectedCategory, 
        handleCategorySelect, 
        resetFilters,

        setPage
    }
}
