import React from 'react'
import useWishlist from '../hooks/useWishlist';

export default function ButtonWishlist({ product }) {
    const { addToWishlist, removeFromWishlist, isInWishlist } = useWishlist()

    const handleClick = () => {
        if (isInWishlist(product)) {
            removeFromWishlist(product)
        } else {
            addToWishlist(product)
        }
    }

    return (
        <button onClick={handleClick} className='btn hover-text-danger border-0 fs-5 p-0'>
            {
                isInWishlist(product) ? (
                    <i role='button' className="bi bi-heart-fill"></i>
                ) : (
                    <i role='button' className="bi bi-heart"></i>
                )
            }
        </button>
    )
}
