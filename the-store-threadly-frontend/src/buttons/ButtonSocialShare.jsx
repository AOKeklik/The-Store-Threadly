import React from 'react';

export default function ButtonSocialShare({ product, text=null }) {
    const handleShare = async () => {
        if (navigator.share) {
        try {
            await navigator.share({
                title: product?.title || 'Check this out!',
                text: product?.short_desc
                    ? product.short_desc.slice(0, 30).concat("...")
                    : '',
                url: `${window.location.origin}/product/${product?.slug}`,
            })
            console.log("Content shared successfully.")
        } catch (error) {
            console.error("Sharing was cancelled or failed:", error)
        }
        } else {
            alert("Your browser does not support native sharing.")
        }
    };

    return (
        <button
            className="btn hover-text-danger border-0 fs-5 p-0"
            onClick={handleShare}
        >
            <i role="button" className="bi bi-share"></i> {text}
        </button>
    )
}
