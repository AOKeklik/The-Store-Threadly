import React from 'react'
import "./ButtonPrimary.css"

export default function ButtonPrimary ({text,size="large"}) {
    const sizeClasses = size === "small" ? "py-1 px-2 small" : "py-2 px-6 big"

    return (
        <div className="button-container">
            <button className={`button-primary ${sizeClasses}`}>
                {text}
            </button>
        </div>
    );
}
