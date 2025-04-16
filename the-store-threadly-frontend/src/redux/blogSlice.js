import { createAsyncThunk, createSlice } from "@reduxjs/toolkit"
import axios from "axios"
import { URL_BLOG } from "../config"

export const fetchAllBlogs = createAsyncThunk(
    "blogs/fetchAll",
    async(_, {rejectWithValue}) => {
        try{
            await new Promise(resolve => setTimeout(resolve, 1000))
            const res = await axios.get(`${URL_BLOG}/all`)
            return res.data
        }catch(err){
            return rejectWithValue(err.response?.data || err.message)
        }
    }
)

const initialState = {
    blogData: [],
    blogLoading: true,
    blogError: null,
}

const blogsSlice = createSlice({
    name: "blogs",
    initialState,
    reducers: {
        // Extra reducers dışında özel işlemler eklenecekse buraya yazılır
    },
    extraReducers: (builder) => {
        builder
            /* blog All */
            .addCase(fetchAllBlogs.pending, (state) => {
                state.blogLoading = true
                state.blogError = null
            })
            .addCase(fetchAllBlogs.fulfilled, (state, action) => {
                const {data} = action.payload
                state.blogData=data
                state.blogLoading = false
            })
            .addCase(fetchAllBlogs.rejected, (state, action) => {
                state.blogLoading = false
                state.blogError = action.payload || "Accoure unexected error."
            })
    }
})

export default blogsSlice.reducer