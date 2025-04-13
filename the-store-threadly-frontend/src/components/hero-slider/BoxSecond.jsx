import React from 'react'
import ButtonPrimary from '../buttons/ButtonPrimary'
import useInViewAnimation from '../hooks/useInViewAnimation'

import img5 from '../../assets/hero-slider/5.jpg'

export default function BoxSecond() {
    const { ref, style } = useInViewAnimation({ direction: "top" })

    return <div 
        ref={ref} 
        style={style}
        className="col-lg-12 col-md-6 mb-3 mt-auto"
    >
        <div className="card border-light-subtle">
            <div className="card-header d-flex justify-content-between p-2 w-100 border-0">
                <span class="badge p-2 bg-danger">New</span>
                <span className='fw-bold'>55.87 PLN</span>
            </div>
            <div className="card-body p-0">
                <img src={img5} alt="" />
            </div>
            <div className="card-footer d-flex justify-content-between p-2 border-0 ">
                <div>
                    <h3 className='fs-6 p-0 m-0'>Product Name</h3>
                    <small>T-Shirt</small>
                </div>
                <ButtonPrimary text="BUY NOW" size='small' />
            </div>
        </div>
    </div>
}
