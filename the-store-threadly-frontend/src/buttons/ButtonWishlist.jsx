import React from 'react'
import { useWishlist } from '../context/wishlistContext';

export default function ButtonWishlist({product}) {
    const { wishlist, addToWishlist, removeFromWishlist, isInWishlist } = useWishlist();
    
    const handleClick = () => {
        if (isInWishlist(product.productId)) {
            const item = wishlist.find(item => item.product_id === product.productId);
            removeFromWishlist(item.id);
        } else {
            addToWishlist(product);
        }
    };

    return (
        <button onClick={handleClick} className='btn hover-text-danger border-0 fs-5 p-0'>
            {
                isInWishlist(product.productId) ? (
                    <i role='button' className="bi bi-heart-fill"></i>
                ) : (
                    <i role='button' className="bi bi-heart"></i>
                )
            }
        </button>
    )
}
