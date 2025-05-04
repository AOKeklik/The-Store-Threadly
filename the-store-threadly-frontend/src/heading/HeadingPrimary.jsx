import React from 'react'
import "./HeadingPrimary.css"

export default function HeadingPrimary({title,size="big",classname=""}) {
    return <div className={`heading-primary-wrapper ${size} ${classname}`}>
        <h2 className="heading-primary">{title}</h2>
    </div>
}
