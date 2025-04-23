import React from 'react'
import { URL_PRODUCT } from '../config'

export default function ButtonLink({product}) {
    return <a href={`${URL_PRODUCT}/${product.slug}`} className="btn hover-text-danger border-0 fs-5 p-0">
        <i className="bi bi-box-arrow-up-right"></i>
    </a>
}
