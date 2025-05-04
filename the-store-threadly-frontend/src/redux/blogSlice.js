import { createAsyncThunk, createSlice } from "@reduxjs/toolkit"
import axiosClient from "../config"

export const fetchAllBlogs = createAsyncThunk(
    "blog/fetchAll",
    async(_, {rejectWithValue}) => {
        try{
            const res = await axiosClient.get(`/blog/all`)
            return res.data
        }catch(err){
            return rejectWithValue(err.response?.data || err.message)
        }
    }
)

export const fetchFilteredBlogs = createAsyncThunk(
    'blog/fetchFiltered',
    async (filters, { rejectWithValue }) => {
        try {
            const query = new URLSearchParams();
            if (filters.category) query.append("category", filters.category)
            if (filters.page) query.append("page", filters.page)

            const response = await axiosClient.get(`blog/filter?${query.toString()}`)
            return response.data
        } catch (error) {
            return rejectWithValue(error.response?.data || error.message)
        }
    }
)

export const fetchOneBlog = createAsyncThunk(
    "blog/fetchOne",
    async(slug, {rejectWithValue}) => {
        try{
            const res = await axiosClient.get(`/blog/${slug}`)
            return res.data
        }catch(err){
            return rejectWithValue(err.response?.data || err.message)
        }
    }
)

const initialState = {
    /* ALL */
    dataAllBlog: [],
    loadingAllBlog: true,
    errorAllBlog: null,

    /* ONE */
    dataBlog: {},
    dataRelatedBlog: [],
    loadingBlog: true,
    errorBlog: null,

    /* FILTERED */
    dataFilteredBlog: [],
    metaFilteredBlog: {},
    loadingFilteredBlog: true,
    errorFilteredBlog: null,
}

const blogsSlice = createSlice({
    name: "blog",
    initialState,
    reducers: {
        // Extra reducers dışında özel işlemler eklenecekse buraya yazılır
    },
    extraReducers: (builder) => {
        builder
            /* Blog All */
            .addCase(fetchAllBlogs.pending, (state) => {
                state.loadingAllBlog = true
                state.errorAllBlog = null
            })
            .addCase(fetchAllBlogs.fulfilled, (state, action) => {
                const {data} = action.payload
                state.dataAllBlog=data
                state.loadingAllBlog = false
            })
            .addCase(fetchAllBlogs.rejected, (state, action) => {
                state.loadingAllBlog = false
                state.errorAllBlog = action.payload || "Accoure unexected error."
            })

            /* Blog One */
            .addCase(fetchOneBlog.pending, (state) => {
                state.loadingBlog = true
                state.errorBlog = null
            })
            .addCase(fetchOneBlog.fulfilled, (state, action) => {
                const {data,dataRelated} = action.payload
                state.dataBlog=data
                state.dataRelatedBlog=dataRelated
                state.loadingBlog = false
            })
            .addCase(fetchOneBlog.rejected, (state, action) => {
                state.loadingBlog = false
                state.errorBlog = action.payload || "Accoure unexected error."
            })

            /* Blog Filtered */
            .addCase(fetchFilteredBlogs.pending, (state) => {
                state.loadingFilteredBlog = true
                state.errorFilteredBlog = null
            })
            .addCase(fetchFilteredBlogs.fulfilled, (state, action) => {
                const {data, meta} = action.payload
                state.dataFilteredBlog=data
                state.metaFilteredBlog=meta
                state.loadingFilteredBlog = false
            })
            .addCase(fetchFilteredBlogs.rejected, (state, action) => {
                state.loadingFilteredBlog = false
                state.errorFilteredBlog = action.payload || "Accoure unexected error."
            })
    }
})

export default blogsSlice.reducer