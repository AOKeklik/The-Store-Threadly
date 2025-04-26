import React from 'react'

import Baner from '../../components/layouts/Baner'
import Loader from '../../components/layouts/Loader'
import BrandSlider from '../../slider/brand-slider/BrandSlider'
import useFetch from '../../hooks/useFetch'
import usePage from '../../hooks/usePage'

export default function TermsPage() {
    const [ brands, loadingBrands ] = useFetch("slider/brand/all")
    const { 
        data, 
        loading, 
        error
    } = usePage("terms")

    return <main className='pb-5'>
        {
            loading || loadingBrands ? (
                <Loader fullHeight={false} />
            ) : (
                <>
                    <Baner {...{
                        title: data.title,
                        cover: data.cover,
                        breadcrumbs: [{path: "",label:data.title}],
                    }} />

                    <div id="page" className='container-xl mb-5 pb-5'>
                        <div className='position-relative'>
                            <div className="mb-5 h-35rem">
                                <img src={data.image} alt="" className='w-100 object-fit-cover h-100' style={{ clipPath: "polygon(0 0, 50% 0, 81% 100%, 0% 100%)"}} />
                            </div>
                            <div className='about-text bg-light position-absolute top-50 end-0 w-75 translate-middle-y p-4 rounded-2 shadow'>
                                <h2 className='mb-5'>{data.title}</h2>
                                <div className='mb-5' dangerouslySetInnerHTML={{ __html: data.desc }} />  
                            </div>
                        </div>
                    </div>

                    <BrandSlider data={brands.data} />
                </>
            )
        }
    </main>
}
