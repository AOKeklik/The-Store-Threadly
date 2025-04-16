import React, { useEffect } from 'react'

import FeaturedProducts from '../components/products/FeaturedProducts'
import HeroSlider from '../components/hero-slider/HeroSlider'
import HeadingPrimary from '../components/layouts/HeadingPrimary'
import DiscountProducts from '../components/products/DiscountProducts'
import MasonryFilterGrid from '../components/products/MasonryFilterGrid'
import Blogs from '../components/blog/Blogs'

import useFetch from '../components/hooks/useFetch'
import { URL_BLOG } from '../config'
import Loader from '../components/layouts/Loader'

import { useDispatch, useSelector } from 'react-redux'
import { fetchAllProducts, fetchFeaturedProducts } from '../redux/productsSlice'
import { fetchAllBlogs } from '../redux/blogSlice'

export default function Home() {
    const dispatch = useDispatch()
    const {
        data,
        loading,
        featuredData,
        loadingFeatured,
    } = useSelector(state => state.products)
    const {
        blogData,
        blogLoading,
    } = useSelector(state => state.blogs)

    useEffect(() => {
        dispatch(fetchAllProducts())
    }, [dispatch])

    useEffect(() => {
        dispatch(fetchFeaturedProducts())
    }, [dispatch])

    useEffect(() => {
        dispatch(fetchAllBlogs())
    }, [dispatch])

    if(loading || loadingFeatured || blogLoading) return <Loader />

    return (
        <>
            <HeroSlider data={data} />
            <HeadingPrimary title="Featured Products" />
            <FeaturedProducts data={featuredData.data} />
            <DiscountProducts data={data} />
            <HeadingPrimary title="Purchase Online" />
            <MasonryFilterGrid data={data} />
            <HeadingPrimary title="From The Blog" />
            <Blogs data={blogData} />
        </>
    )
}