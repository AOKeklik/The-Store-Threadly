import { useDispatch, useSelector } from 'react-redux'
import {
    addToCart,
    increaseQuantity,
    decreaseQuantity,
    removeFromCart
} from '../redux/cartSlice'

export default function useCart () {
    const dispatch = useDispatch()
    const deliveryPrice = 15.55
    const discount = 10.16
    const {items, totalQuantity, totalPrice} = useSelector(state => state.cart)

    const generateUniqueId = (product) => {
        if (!product.variantId) {
            return `product-id-${product.productId}`
        }
    
        return `product-id-${product.productId}_variant-id-${product.variantId}`
    }

    const findCartItem = (product) => {
        const uniqueId = generateUniqueId(product)
        return items.find(item => item.uniqueId === uniqueId)
    }

    const getQuantity = (product) => {
        return findCartItem(product)?.quantity || 0
    }

    const getStockStatus =(product) => {
        return isInStock(product) 
            ? `${product.stock} available` 
            : <span className='text-danger'>Out of stock</span>
    }

    const isInCart = (product) => {
        return !!findCartItem(product)
    }

    const isInStock = (product) => {
        return (product?.stock ?? 0) > 0
    }
    
    /* Price */

    const getDeliveryPrice = () => {
        return `${deliveryPrice.toFixed(2)} PLN`
    }

    const getDiscountPrice = () => {
        return `${discount.toFixed(2)} PLN`
    }

    function getItemDiscountPercent(product) {
        const price = Number(product.base_price)
        const offerPrice = Number(product.offer_price)

        if (!price || !offerPrice || offerPrice >= price) return null    
        const discount = Math.round(((price - offerPrice) / price) * 100)

        return `-${discount}%`;
    }

    const getItemPrice = (product) => {
        const price = Number(product.price)

        return `${price} PLN`
    }

    const getItemSubTotalPrice = (product) => {
        const item = findCartItem(product)
        const itemCount = getQuantity(product)
        
        if(!item || !itemCount) return "00.00 PLN"

        const price = item.price * itemCount

        return `${price.toFixed(2)} PLN`
    }

    const getSubTotalPrice = () => {
        const price = Number(totalPrice) || 0;
        return `${price.toFixed(2)} PLN`
    }

    const getTotalPrice = () => {
        const price = (Number(totalPrice) + deliveryPrice) - discount || 0;
        return `${price.toFixed(2)} PLN`
    }

    return {
        items,
        totalQuantity,
        
        isInCart,
        isInStock,

        getQuantity,
        getStockStatus,
        getDiscountPrice,
        getDeliveryPrice,
        getItemDiscountPercent,
        getItemPrice,
        getItemSubTotalPrice,
        getSubTotalPrice,
        getTotalPrice,

        addToCart: (item) => dispatch(addToCart(item)),
        increaseQuantity: (product) => dispatch(increaseQuantity(product)),
        decreaseQuantity: (product) => dispatch(decreaseQuantity(product)),
        removeFromCart: (uniqueId) => dispatch(removeFromCart(uniqueId)),
    }
}