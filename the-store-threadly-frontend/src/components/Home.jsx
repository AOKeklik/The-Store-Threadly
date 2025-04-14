import React from 'react'

import FeaturedProducts from './products/FeaturedProducts'
import HeroSlider from './hero-slider/HeroSlider'
import SectionTitle from './SectionTitle/SectionTitle'
import DiscountProducts from './products/DiscountProducts'
import MasonryFilterGrid from './products/MasonryFilterGrid'

export default function Home() {
    

    return (
        <>
            <HeroSlider />
            <SectionTitle title="Featured Products" />
            <FeaturedProducts />
            <DiscountProducts />
            <SectionTitle title="Purchase Online" />
            <MasonryFilterGrid />
        </>
    )
}