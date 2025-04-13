import React from 'react'
import "./ButtonSlider.css"

export default function ButtonSlider ({text}) {
    return (
        <div className='button-container animate__animated animate__fadeInUp animate__delay-1s'>
            <button className='slider-button '>
                {text}
            </button>
        </div>
    )
}
