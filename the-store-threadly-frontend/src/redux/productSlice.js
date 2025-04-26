// features/product/productsSlice.js
import { createSlice, createAsyncThunk } from '@reduxjs/toolkit'
import axiosClient from '../config'
import { arangedData } from './data';


export const fetchAllProducts = createAsyncThunk(
    'product/fetchAll',
    async (_, { rejectWithValue }) => {
        try {
            await new Promise(resolve => setTimeout(resolve, 1000))
            const response = await axiosClient.get("/product/all");
            return response.data
        } catch (err) {
            return rejectWithValue(err.response?.data || err.message)
        }
    }
)


export const fetchFilteredProducts = createAsyncThunk(
    'product/fetchFiltered',
    async (filters, { rejectWithValue }) => {
        try {
            const query = new URLSearchParams();
            if (filters.color) query.append("color", filters.color)
            if (filters.size) query.append("size", filters.size)
            if (filters.gender) query.append("gender", filters.gender)
            if (filters.category) query.append("category", filters.category)
            if (filters.page) query.append("page", filters.page)

            await new Promise(resolve => setTimeout(resolve, 1000))
            const response = await axiosClient.get(`/product/filter?${query.toString()}`)
            return response.data
        } catch (error) {
            return rejectWithValue(error.response?.data || error.message)
        }
    }
)


export const fetchFeaturedProducts = createAsyncThunk(
    'product/fetchFeatured',
    async (_, { rejectWithValue }) => {
        try {
            await new Promise(resolve => setTimeout(resolve, 1000))
            const response = await axiosClient.get(`/product/all/featured`)
            return response.data
        } catch (err) {
            return rejectWithValue(err.response?.data || err.message)
        }
    }
)

export const fetchOneProduct = createAsyncThunk(
    "product/fetchOne",
    async(slug, {rejectWithValue}) => {
        try{
            await new Promise(resolve => setTimeout(resolve, 1000))
            const res = await axiosClient.get(`/product/${slug}`)
            return res.data
        }catch(err){
            return rejectWithValue(err.response?.data || err.message)
        }
    }
)


const initialState = {
   /* PRODUCT ALL */
    productAll: {
        data: [],
        loading: false,
        error: null,
    },

    /* PRODUCT ONE */
    productOne: {
        data: {},
        dataRelated: [],
        loading: true,
        error: null,
    },

    /* PRODUCT FILTERED */
    productFiltered: {
        data: [],
        meta: {},
        loading: true,
        error: null,
    },

    /* PRODUCT FEATURED */
    productFeatured: {
        data: [],
        loading: false,
        error: null,
    }
};

const productSlice = createSlice({
    name: 'product',
    initialState,
    reducers: {
        // Extra reducers dışında özel işlemler eklenecekse buraya yazılır
    },
    extraReducers: (builder) => {
        builder

            /* ////////// PRODUCT ALL ////////// */
            .addCase(fetchAllProducts.pending, (state) => {
                state.productAll.loading = true
                state.productAll.error = null
            })
            .addCase(fetchAllProducts.fulfilled, (state, action) => {
                const {data} = action.payload

                state.productAll.data = arangedData(data)
                state.productAll.loading = false
            })
            .addCase(fetchAllProducts.rejected, (state, action) => {
                state.productAll.loading = false
                state.productAll.error = action.payload || 'Bir hata oluştu'
            })

            /* ////////// PRODUCT ONE ////////// */
            .addCase(fetchOneProduct.pending, (state) => {
                state.productOne.loading = true
                state.productOne.error = null
            })
            .addCase(fetchOneProduct.fulfilled, (state, action) => {
                const {data,dataRelated} = action.payload

                state.productOne.data = data
                state.productOne.dataRelated=arangedData(dataRelated)
                state.productOne.loading = false
            })
            .addCase(fetchOneProduct.rejected, (state, action) => {
                state.productOne.loading = false
                state.productOne.error = action.payload || 'Bir hata oluştu'
            })

            /* ////////// PRODUCT FILTERED ////////// */
            .addCase(fetchFilteredProducts.pending, (state) => {
                state.productFiltered.loading = true;
                state.productFiltered.error = null;
            })
            .addCase(fetchFilteredProducts.fulfilled, (state, action) => {
                const {data, meta} = action.payload
                state.productFiltered.data = arangedData(data)
                state.productFiltered.meta = meta
                state.productFiltered.loading = false;
            })
            .addCase(fetchFilteredProducts.rejected, (state, action) => {
                state.productFiltered.loading = false;
                state.productFiltered.error = action.payload || 'Bir hata oluştu';
            })

            /* ////////// PRODUCT FEAUTRED ////////// */
            .addCase(fetchFeaturedProducts.pending, (state) => {
                state.productFeatured.loading = true;
                state.productFeatured.error = null;
            })
            .addCase(fetchFeaturedProducts.fulfilled, (state, action) => {
                const {data} = action.payload
                state.productFeatured.data = arangedData(data)
                state.productFeatured.loading = false;
            })
            .addCase(fetchFeaturedProducts.rejected, (state, action) => {
                state.productFeatured.loading = false;
                state.productFeatured.error = action.payload || 'Bir hata oluştu';
            })
    },
})

export default productSlice.reducer;
