import React, { useEffect } from 'react'
import { useParams } from 'react-router-dom'

import { useDispatch, useSelector } from 'react-redux'
import { fetchOneProduct } from '../../redux/productSlice'
import Baner from '../../components/layouts/Baner'
import Loader from '../../components/layouts/Loader'

export default function ProductSinglePage() {
    const dispatch = useDispatch()
    const { slug } = useParams()
    const { 
        productData, 
        productLoading, 
        productError 
    } = useSelector(state => state.product)

    useEffect(() => {
        if (slug) {
            dispatch(fetchOneProduct(slug))
        }
    }, [dispatch, slug])

    console.log(productData)

    if(productLoading) return <Loader />

    return <>
        <Baner {...{
            title: productData.title,
            breadcrumbs: [
                {path: "/products",label:"Products"},
                {path:"",label:productData.title}
            ],
        }} />


        <main className='container-md'>
            <div className="row">
                <div className="col-md-4">
                    <img src={productData.thumbnail} className='w-100' alt="" />
                </div>
                <div className="col-md-8">
                    
                </div>
            </div>
        </main>
    </>
}
