import { useDispatch, useSelector } from 'react-redux'
import {
    addToCart,
    increaseQuantity,
    decreaseQuantity,
    removeFromCart,
    clearCart,
} from '../../redux/cartSlice'
import useHelpers from '../../utilities/useHelpers'
import { generateUniqueId } from '../../utilities/helpers'

export default function useCart () {
    const dispatch = useDispatch()
    
    const { 
        getItemPrice, 
        getDeliveryPrice, 
        getSubTotalPrice,
        getTotalPrice,
        getDiscountAmount,
        formatedPrice 
    } = useHelpers()

    const {items, totalQuantity} = useSelector(state => state.cart)

    const findCartItem = (product) => {
        const uniqueId = generateUniqueId(product)
        return items.find(item => item.uniqueId === uniqueId)
    }

    const isInCart = (product) => {
        return !!findCartItem(product)
    }

    const isCartEmpty = items.length === 0

    const getQuantity = (product) => {
        return findCartItem(product)?.quantity || 0
    }

    const getItemSubTotalPrice = (product) => {
        const item = findCartItem(product)
        const itemCount = getQuantity(product)
        
        if(!item || !itemCount) return formatedPrice (0)

        const price = item.price * itemCount

        return formatedPrice (price)
    }

    return {
        items,
        getItemPrice,
        getSubTotalPrice,
        getDeliveryPrice,
        getDiscountAmount,
        getTotalPrice,
        totalQuantity,
        
        isInCart,
        isCartEmpty,

        getQuantity,
        getItemSubTotalPrice,

        addToCart: (item) => dispatch(addToCart(item)),
        increaseQuantity: (product) => dispatch(increaseQuantity(product)),
        decreaseQuantity: (product) => dispatch(decreaseQuantity(product)),
        removeFromCart: (uniqueId) => dispatch(removeFromCart(uniqueId)),
        clearCart: () => dispatch(clearCart()),
    }
}