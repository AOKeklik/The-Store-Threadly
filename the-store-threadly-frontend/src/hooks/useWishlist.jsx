import { useSelector, useDispatch } from "react-redux";
import { useEffect } from "react";

import {
    fetchWishlistAPI,
    addToWishlistAPI,
    removeFromWishlistAPI,
    clearWishlist,
} from "../redux/wishlistSlice";

export default function useWishlist() {
    const dispatch = useDispatch();

    const { items, quantity, loading, error } = useSelector((state) => state.wishlist);

    useEffect(() => {
        dispatch(fetchWishlistAPI());
    }, [dispatch]);

    const addToWishlist = (product) => {
        dispatch(addToWishlistAPI(product));
    };

    const removeFromWishlist = (product) => {
        dispatch(removeFromWishlistAPI(product));
    };

    const isInWishlist = (product) => {
        return items.some((item) => item.variantId === product.variantId);
    };

    const isWishlistEmpty = () => {
        return items.length === 0;
    };

    return {
        items,
        wishlistCount:quantity,
        wishlistLoading:loading,
        error,
        isInWishlist,
        isWishlistEmpty,
        addToWishlist,
        removeFromWishlist,
        clearWishlist: () => dispatch(clearWishlist()),
    };
}
