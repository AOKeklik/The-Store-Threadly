import React from 'react'
import useWishlist from '../hooks/useWishlist';

export default function ButtonWishlist({ product }) {
    const {
        addToWishlist,
        removeFromWishlist,
        isInWishlist,
        isLoadingWishlistItem,
    } = useWishlist()

    const handleClick = () => {
        if (isInWishlist(product)) {
            removeFromWishlist(product)
        } else {
            addToWishlist(product)
        }
    }

    return (
        <button 
            onClick={handleClick} 
            disabled={isLoadingWishlistItem(product)}
            className='btn hover-text-danger border-0 fs-5 p-0'
        >
            {
                isLoadingWishlistItem(product) ? (
                    <span className="spinner-grow spinner-grow-sm bg-danger" aria-hidden="true"></span>
                ) : (
                    isInWishlist(product) ? (
                        <i role='button' className="bi bi-heart-fill"></i>
                    ) : (
                        <i role='button' className="bi bi-heart"></i>
                    )
                )
            }
        </button>
    )
}
