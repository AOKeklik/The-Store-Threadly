import React from 'react'
import "./ButtonPrimary.css"

export default function ButtonPrimary ({text,size="large",fill="secondary",type="button"}) {
    const sizeClasses = size === "small" ? "py-1 px-2 small" : "py-2 px-6 big"
    const fillClass = fill === "primary" ? "fill-primary" : "fill-secondary";

    return (
        <div className="button-container">
            <button 
                type={type}
                className={`button-primary ${fillClass} ${sizeClasses}`}
            >
                {text}
            </button>
        </div>
    );
}
