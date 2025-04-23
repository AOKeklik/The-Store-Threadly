import React from 'react'
import "./ButtonPrimary.css"

export default function ButtonPrimary ({
    text,
    size="large",
    fill="secondary",
    type="button",
    href = null,
    onClick=null,
    target="_self",
}) {
    const sizeClasses = size === "small" ? "py-1 px-2 small" : "py-2 px-6 big"
    const fillClass = fill === "primary" ? "fill-primary" : "fill-secondary";

    const handleClick = (e) => {
        if (onClick) {
            onClick(e)
        }
        if (href && !e.defaultPrevented) {
            window.location.href = href;
        }
    }

    return (
        <div className="button-container">
            <button
                onClick={handleClick}
                type={type}
                className={`button-primary ${fillClass} ${sizeClasses}`}
            >
                {text}
            </button>
        </div>
    );
}
