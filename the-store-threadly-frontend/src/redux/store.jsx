import { configureStore } from '@reduxjs/toolkit';
import { Provider } from 'react-redux';

import authSlice from './authSlice';
import cartSlice from './cartSlice';
import wishlistSlice from './wishlistSlice';
import productSlice from './productSlice';
import filterSlice from './filterSlice';
import blogSlice from './blogSlice';
import formSlice from './formSlice';
import pageSlice from './pageSlice';

const saveToLocalStorage = (state) => {
    localStorage.setItem('cart', JSON.stringify(state.cart));
    localStorage.setItem('wishlist', JSON.stringify(state.wishlist));
};

const loadFromLocalStorage = (key) => {
    try {
        const serializedState = localStorage.getItem(key);
        return serializedState ? JSON.parse(serializedState) : undefined;
    } catch (e) {
        return undefined;
    }
};

const store = configureStore({
    reducer: {
        auth: authSlice,
        cart: cartSlice,
        wishlist: wishlistSlice,
        product: productSlice,
        filters: filterSlice,
        blog: blogSlice,
        form: formSlice,
        page: pageSlice,
    },
    preloadedState: {
        cart: loadFromLocalStorage('cart'),
        wishlist: loadFromLocalStorage('wishlist'),
    },
});

store.subscribe(() => saveToLocalStorage(store.getState()));

export const StoreProvider = ({ children }) => {
    return <Provider store={store}>{children}</Provider>;
};
