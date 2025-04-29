import { createSlice } from "@reduxjs/toolkit"
import { toast } from "react-toastify"
import generateUniqueId from "../utilities/generateUniqueId"


const initialState = {
    items: [],
    totalQuantity: 0,
    totalPrice: 0
}

const cartSlice = createSlice({
    name: 'cart',
    initialState,
    reducers: {
        addToCart: (state, action) => {
            const newItem = action.payload
            const uniqueId = generateUniqueId(newItem)
            const existingItem = state.items.find(item => item.uniqueId === uniqueId)

            if (existingItem) {
                existingItem.quantity += newItem.quantity || 1
            } else {
                state.items.push({
                    ...newItem,
                    uniqueId,
                    quantity: newItem.quantity || 1
                })
            }
            cartSlice.caseReducers.updateTotals(state)
            
            /* toast */            
            toast.success("Item successfully added to your cart.")
        },
        removeFromCart: (state, action) => {
            const uniqueId = generateUniqueId(action.payload)

            state.items = state.items.filter(item => item.uniqueId !== uniqueId)
            cartSlice.caseReducers.updateTotals(state)

            /* toast */ 
            toast.info("Item removed from your cart.")
        },
        increaseQuantity: (state, action) => {
            const uniqueId = generateUniqueId(action.payload)
            const item = state.items.find(i => i.uniqueId === uniqueId)

            if (item && item.quantity < item.maxQuantity) item.quantity += 1
            cartSlice.caseReducers.updateTotals(state)
        },
        decreaseQuantity: (state, action) => {
            const uniqueId = generateUniqueId(action.payload)
            const item = state.items.find(i => i.uniqueId === uniqueId)

            if (item && item.quantity > 1) item.quantity -= 1
            cartSlice.caseReducers.updateTotals(state)
        },
        clearCart: (state) => {
            state.items = []
            state.totalPrice = 0
            state.totalQuantity = 0
            
            /* toast */ 
            toast.info("All items have been removed from your cart.")
        },
        updateTotals: (state) => {
            state.totalQuantity = state.items.reduce((sum, item) => sum + item.quantity, 0)
            state.totalPrice = state.items.reduce((sum, item) => sum + item.price * item.quantity, 0)
        },
    }
})

export const {
    addToCart,
    removeFromCart,
    increaseQuantity,
    decreaseQuantity,
    clearCart
} = cartSlice.actions

export default cartSlice.reducer
