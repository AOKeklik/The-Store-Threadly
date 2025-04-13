import React from 'react'


import useFetch from '../hooks/useFetch'
import { URL_PRODUCT } from '../../config'
import Loader from '../loader/Loader'
import ProductItem from './Producttem'



export default function Products() {
    const [{ data = [], colors = [], sizes = [] }, loading, error ] = useFetch(`${URL_PRODUCT}/all`)

    console.log(data)

    if(loading) return <Loader />
    return <div className="container">
        <div className="row">
            {data.map((product, i) => (
                <div key={i} className="col-lg-4 mb-4">
                    <ProductItem product={product} />
                </div>
            ))}
        </div>
  </div>
}