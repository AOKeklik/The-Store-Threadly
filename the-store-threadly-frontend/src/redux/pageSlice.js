import { createAsyncThunk, createSlice } from "@reduxjs/toolkit";
import axiosClient from "../config";

export const fetchPage = createAsyncThunk(
    "page/fetchPage",
    async (type, { rejectWithValue }) => {
        try {
            await new Promise(resolve => setTimeout(resolve, 1000));
            const res = await axiosClient.get(`/page/${type}/get`);
            return { type, data: res.data };
        } catch (err) {
            return rejectWithValue({
                type,
                error: err.response?.data || err.message
            });
        }
    }
);

const initialState = {
  pages: {} // Changed from 'page' to 'pages' to match usage below
};

const pageSlice = createSlice({
    name: "page",
    initialState,
    reducers: {},
    extraReducers: (builder) => {
        builder
        .addCase(fetchPage.pending, (state, action) => {
            const type = action.meta.arg;
            state.pages[type] = {
                ...(state.pages[type] || {}),
                loading: true,
                error: null
            };
        })
        .addCase(fetchPage.fulfilled, (state, action) => {
            const { type, data } = action.payload;
            state.pages[type] = {
                data: data.data, // Changed from action.payload to destructured values
                loading: false,
                error: null
            };
        })
        .addCase(fetchPage.rejected, (state, action) => {
            const type = action.payload.type; // Changed to get type from payload
            state.pages[type] = {
                ...(state.pages[type] || {}),
                loading: false,
                error: action.payload.error || "An unexpected error occurred."
            };
        });
    }
});

export default pageSlice.reducer;