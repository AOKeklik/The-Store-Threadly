import React from 'react'
import "./HeadingPrimary.css"

export default function HeadingPrimary({title,size="big"}) {
    return <div className={`heading-primary-wrapper ${size}`}>
        <h2 className="heading-primary">{title}</h2>
    </div>
}
