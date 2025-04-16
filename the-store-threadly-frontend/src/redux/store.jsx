import { configureStore } from '@reduxjs/toolkit';
import { Provider } from 'react-redux';

import productsSlice from './productsSlice'
import productSlice from './productSlice'
import filterSlice from './filterSlice'
import blogSlice from './blogSlice'

const store = configureStore({
    reducer: {
        products: productsSlice,
        product: productSlice,
        filters: filterSlice,
        blogs: blogSlice,
    },
});

export const StoreProvider = ({ children }) => {
    return <Provider store={store}>{children}</Provider>;
};