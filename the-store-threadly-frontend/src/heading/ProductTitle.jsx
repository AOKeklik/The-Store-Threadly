import React from 'react'
import { Link } from 'react-router-dom'
import { URL_PRODUCT } from '../config'

export default function ProductTitle({product}) {
    return <Link to={`${URL_PRODUCT}/${product.slug}`} className="text-gray text-decoration-none hover-text-danger">
        <h3 className='fs-6 p-0 m-0'>{product.title}</h3>
    </Link>
}
