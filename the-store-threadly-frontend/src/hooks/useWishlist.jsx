import { useSelector, useDispatch } from "react-redux"
import { useEffect } from "react"
import { toast } from "react-toastify"
import generateUniqueId from "../utilities/generateUniqueId"

import {
  fetchWishlist,
  addToWishlist,
  removeFromWishlist,
  clearWishlist,
} from "../redux/wishlistSlice"

export default function useWishlist() {
    const dispatch = useDispatch()
    const { 
        items, 
        count, 
        status, 
        error,

        loadingItems,

        add: { data: dataAdd, loading: loadingAdd},
        remove: { data: dataRemove, loading: loadingRemove},
        clear: { data: dataClear, loading: loadingClear},

    } = useSelector((state) => state.wishlist)

    useEffect(() => {
        const loadWishlist = async () => {
            try {
                await dispatch(fetchWishlist()).unwrap()
            } catch (err) {
                toast.error(err || "Failed to load wishlist")
            }
        }
        
        loadWishlist()
    }, [dispatch])

    const handleAddToWishlist = async (product) => {
        try {
            await dispatch(addToWishlist(product)).unwrap()
            toast.success(dataAdd.message || "Added to wishlist successfully!")
        } catch (err) {
            toast.error(err?.message || "Failed to add wishlist")
            console.log("Add to wishlist: ", err)
        }
    }

    const handleRemoveFromWishlist = async (product) => {
        try {
            await dispatch(removeFromWishlist(product)).unwrap()
            toast.success(dataRemove.message || "Removed from wishlist successfully!")
        } catch (err) {
            toast.error(err?.message || "Failed to remove wishlist")
            console.log("Remove from wishlist: ", err)
        }
    }

    const handleClearWishlist = async () => {
        try {
            await dispatch(clearWishlist())
            toast.info("Wishlist cleared")
        } catch (err) {
            console.log("Clear wishlist: ", err)
        }
    }

    const isInWishlist = (product) => {        
        return items.some((item) => item.uniqueId === generateUniqueId(product))
    }

    const isLoadingWishlistItem = (product) => {
        return (loadingAdd || loadingRemove) && loadingItems.find(item => generateUniqueId(product) === item)
    }

    const isClearingWishlist = () => {
        return loadingClear
    }

    const isWishlistEmpty = items.length === 0

    console.log(loadingItems)

    return {
        items,
        wishlistCount: count,
        isLoading: status === "loading",
        error,
        
        isInWishlist,
        isLoadingWishlistItem,
        isWishlistEmpty,
        isClearingWishlist,


        addToWishlist: handleAddToWishlist,
        removeFromWishlist: handleRemoveFromWishlist,
        clearWishlist: handleClearWishlist,
    }
}