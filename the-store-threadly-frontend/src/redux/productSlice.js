import { createAsyncThunk, createSlice } from "@reduxjs/toolkit"
import axios from "axios"
import { URL_PRODUCT } from "../config"

export const fetchOneProduct = createAsyncThunk(
    "product/fetchOne",
    async(slug, {rejectWithValue}) => {
        try{
            await new Promise(resolve => setTimeout(resolve, 1000))
            const res = await axios.get(`${URL_PRODUCT}/${slug}`)
            return res.data
        }catch(err){
            return rejectWithValue(err.response?.data || err.message)
        }
    }
)

const initialState = {
    productData: [],
    productLoading: true,
    productError: null,
}

const productSlice = createSlice({
    name: "product",
    initialState,
    reducers: {
        // Extra reducers dışında özel işlemler eklenecekse buraya yazılır
    },
    extraReducers: (builder) => {
        builder
            /* blog All */
            .addCase(fetchOneProduct.pending, (state) => {
                state.productLoading = true
                state.productError = null
            })
            .addCase(fetchOneProduct.fulfilled, (state, action) => {
                const {data} = action.payload
                state.productData=data
                state.productLoading = false
            })
            .addCase(fetchOneProduct.rejected, (state, action) => {
                state.productLoading = false
                state.productError = action.payload || "Accoure unexected error."
            })
    }
})

export default productSlice.reducer