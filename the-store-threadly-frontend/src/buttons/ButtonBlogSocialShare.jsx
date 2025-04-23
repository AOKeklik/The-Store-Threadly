import React from 'react';

export default function ButtonBlogSocialShare({ blog }) {
    const handleShare = async () => {
        if (navigator.share) {
            try {
                await navigator.share({
                    title: blog?.title || 'Check this out!',
                    text: blog?.desc
                        ? blog?.desc.slice(0,150).concat("...")
                        : '',
                    url: `${window.location.origin}/blog/${blog?.slug}`,
                })
                console.log("Content shared successfully.")
            } catch (error) {
                console.error("Sharing was cancelled or failed:", error)
            }
        } else {
            alert("Your browser does not support native sharing.")
        }
    }

    return (
        <button
            className="btn hover-text-danger border-0 fs-08 p-0"
            onClick={handleShare}
        >
            <i role="button" className="bi bi-share"></i> Share
        </button>
    )
}
