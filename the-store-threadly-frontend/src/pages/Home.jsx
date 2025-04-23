import React from 'react'

import HeroSlider from '../slider/hero-slider/HeroSlider'
import HeadingPrimary from '../components/layouts/HeadingPrimary'
import MasonryFilterGrid from '../components/products/MasonryFilterGrid'
import Loader from '../components/layouts/Loader'

import useProducts from '../hooks/useProducts'
import useFetch from '../hooks/useFetch'
import useBlog from '../hooks/useBlog'

import FeaturedSlider from '../slider/FeaturedSlider'
import BrandSlider from '../slider/brand-slider/BrandSlider'
import DiscountSlider from '../slider/DiscountSlider'
import BlogSlider from '../slider/blog-slider/BlogSlider'

export default function Home() {
    const {
        data,
        loading,

        featuredData,
        loadingFeatured,
    } = useProducts()
    const [ dataHoerSlider, loadingHeroSlider ] = useFetch("slider/hero/all")
    const [ dataBrandSlider, loadingBrandSlider ] = useFetch("slider/brand/all")
    const { dataAllBlog, loadingAllBlog } = useBlog()

    if(
        loading || 
        loadingFeatured || 
        loadingAllBlog || 
        loadingHeroSlider || 
        loadingBrandSlider) return <Loader />

    return (
        <>
            <HeroSlider products={data} sliders={dataHoerSlider.data} />
            <HeadingPrimary title="Featured Products" />
            <FeaturedSlider data={featuredData} />
            <DiscountSlider data={data} />
            <HeadingPrimary title="Our Brands" />
            <BrandSlider data={dataBrandSlider.data} />
            <HeadingPrimary title="Purchase Online" />
            <MasonryFilterGrid data={data} />
            <HeadingPrimary title="From The Blog" />
            <BlogSlider data={dataAllBlog} />
        </>
    )
}