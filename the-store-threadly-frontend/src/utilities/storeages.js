const CART_STORAGE_KEY = "cart"
const DELIVERY_STORAGE_KEY = "delivery"
const COUPON_STORAGE_KEY = "coupon"
const WISHLIST_STORAGE_KEY = "wishlist"

const safeParse = (item) => {
    try {
      return item ? JSON.parse(item) : null
    } catch (error) {
      console.error("Failed to parse storage item:", error)
      return null
    }
}

/* cart */
export const getCartStorage = () => {
    if (typeof window === "undefined") return null
    return safeParse(localStorage.getItem(CART_STORAGE_KEY))
}

/* wishlist */
export const getWishlistStorage = () => {
    if (typeof window === "undefined") return null
    return safeParse(localStorage.getItem(WISHLIST_STORAGE_KEY))
}

/* coupon */
export const getCouponStorage = () => {
    if (typeof window === "undefined") return null
    return safeParse(localStorage.getItem(COUPON_STORAGE_KEY))
}
export const setCouponStorage = (coupon) => {
    if (typeof window === "undefined") return
    localStorage.setItem(COUPON_STORAGE_KEY, JSON.stringify(coupon))
}
export const removeCouponStorage = () => {
    if (typeof window === "undefined") return
    localStorage.removeItem(COUPON_STORAGE_KEY)
}