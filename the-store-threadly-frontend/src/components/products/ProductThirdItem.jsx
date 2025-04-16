import React from 'react'

import img1 from "../../assets/discount-slider/1.jpg"

export default function ProductThirdItem({product}) {
    return <div className="section-product-third-item">
        <div className="card border-light-subtle">
            <div className="card-body p-0 position-relative overflow-hidden">
               <div className='position-absolute top-100 d-flex flex-column gap-2 p-2 bg-danger bg-opacity-50 w-100 h-100 d-felx justify-content-center align-items-center fw-bold text-white'>
                    <a href='#' className='text-white hover-text-warning lh-1'>Product New Name</a>
                    <span>329 PLN</span>
               </div>
                <img className='w-100' src={img1} alt="" />
            </div>
        </div>
    </div>
}