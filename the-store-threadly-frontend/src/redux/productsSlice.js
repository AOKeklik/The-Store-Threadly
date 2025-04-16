// features/product/productsSlice.js
import { createSlice, createAsyncThunk } from '@reduxjs/toolkit';
import axios from 'axios';
import { URL_PRODUCT } from '../config';


export const fetchAllProducts = createAsyncThunk(
    'products/fetchAll',
    async (_, { rejectWithValue }) => {
        try {
            await new Promise(resolve => setTimeout(resolve, 1000))
            const response = await axios.get(`${URL_PRODUCT}/all`);
            return response.data;
        } catch (err) {
            return rejectWithValue(err.response?.data || err.message)
        }
    }
)

export const fetchFilteredProducts = createAsyncThunk(
    'products/fetchFiltered',
    async (filters, { rejectWithValue }) => {
        try {
            const query = new URLSearchParams();
            if (filters.color) query.append("color", filters.color)
            if (filters.size) query.append("size", filters.size)
            if (filters.gender) query.append("gender", filters.gender)
            if (filters.category) query.append("category", filters.category)

            await new Promise(resolve => setTimeout(resolve, 1000))
            const response = await axios.get(`${URL_PRODUCT}/filter?${query.toString()}`)
            return response.data
        } catch (error) {
            return rejectWithValue(error.response?.data || error.message)
        }
    }
)

export const fetchFeaturedProducts = createAsyncThunk(
    'products/fetchFeatured',
    async (_, { rejectWithValue }) => {
        try {
            await new Promise(resolve => setTimeout(resolve, 1000))
            const response = await axios.get(`${URL_PRODUCT}/all/featured`)
            return response.data
        } catch (err) {
            return rejectWithValue(err.response?.data || err.message)
        }
    }
)

const initialState = {
    /* product all */
    data: [],
    colors: [],
    sizes: [],
    categories: [],
    loading: true,
    error: null,

    /* product filter */
    filteredData: [],
    loadingFiltered: false,
    errorFiltered: null,

    /* product featured */
    featuredData: [],
    loadingFeatured: true,
    errorFeatured: null,
};

const productSlice = createSlice({
    name: 'products',
    initialState,
    reducers: {
        // Extra reducers dışında özel işlemler eklenecekse buraya yazılır
    },
    extraReducers: (builder) => {
        builder

            /* product all */
            .addCase(fetchAllProducts.pending, (state) => {
                state.loading = true
                state.error = null
            })
            .addCase(fetchAllProducts.fulfilled, (state, action) => {
                const { data, colors, sizes, categories } = action.payload
                state.data = data
                state.colors = colors
                state.sizes = sizes
                state.categories = categories
                state.loading = false
            })
            .addCase(fetchAllProducts.rejected, (state, action) => {
                state.loading = false
                state.error = action.payload || 'Bir hata oluştu'
            })

            /* product filter */
            .addCase(fetchFilteredProducts.pending, (state) => {
                state.loadingFiltered = true;
                state.errorFiltered = null;
            })
            .addCase(fetchFilteredProducts.fulfilled, (state, action) => {
                state.filteredData = action.payload;
                state.loadingFiltered = false;
            })
            .addCase(fetchFilteredProducts.rejected, (state, action) => {
                state.loadingFiltered = false;
                state.errorFiltered = action.payload || 'Bir hata oluştu';
            })

            /* product featured */
            .addCase(fetchFeaturedProducts.pending, (state) => {
                state.loadingFeatured = true;
                state.errorFeatured = null;
            })
            .addCase(fetchFeaturedProducts.fulfilled, (state, action) => {
                state.featuredData = action.payload;
                state.loadingFeatured = false;
            })
            .addCase(fetchFeaturedProducts.rejected, (state, action) => {
                state.loadingFeatured = false;
                state.errorFeatured = action.payload || 'Bir hata oluştu';
            })
    },
})

export default productSlice.reducer;
