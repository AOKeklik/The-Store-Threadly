export const generateUniqueId = (product)  => {
    return product.variantId 
        ? `product-id-${product.productId}_variant-id-${product.variantId}`
        : `product-id-${product.productId}`;
}

export const getItemDiscountPercent = (product) => {
    const price = Number(product.base_price)
    const offerPrice = Number(product.offer_price)

    if (!price || !offerPrice || offerPrice >= price) return null    
    const discount = Math.round(((price - offerPrice) / price) * 100)

    return `-${discount}%`;
}

export const isInStock = (product) => {
    return (product?.stock ?? 0) > 0
}

export const getStockStatus =(product) => {
    return isInStock(product) 
        ? `${product.stock} available` 
        : <span className='text-danger'>Out of stock</span>
}

export const isAuthenticated = () => {
    return typeof window !== "undefined" && !!localStorage.getItem("user")
}