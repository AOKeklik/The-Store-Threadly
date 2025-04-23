import { configureStore } from '@reduxjs/toolkit';
import { Provider } from 'react-redux';

import cartSlice from './cartSlice'
import productSlice from './productSlice'
import filterSlice from './filterSlice'
import blogSlice from './blogSlice'

const saveToLocalStorage = (state) => {
    localStorage.setItem('cart', JSON.stringify(state.cart))
}

const loadFromLocalStorage = () => {
    try {
        const serializedState = localStorage.getItem('cart')
        return serializedState ? JSON.parse(serializedState) : undefined
    } catch (e) {
        return undefined
    }
}

const store = configureStore({
    reducer: {
        cart: cartSlice,
        product: productSlice,
        filters: filterSlice,
        blog: blogSlice,
    },
    preloadedState: {
        cart: loadFromLocalStorage(),
    },
})

store.subscribe(() => saveToLocalStorage(store.getState()))


export const StoreProvider = ({ children }) => {
    return <Provider store={store}>{children}</Provider>;
};