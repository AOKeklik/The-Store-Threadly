import { createAsyncThunk, createSlice } from "@reduxjs/toolkit"
import axiosClient from "../config"

export const storeSubscriber = createAsyncThunk(
    "form/subscriber/store",
    async(formData, {rejectWithValue}) => {
        try{
            await new Promise(resolve => setTimeout(resolve, 1000))
            const res = await axiosClient.post(`/subscriber/store`, formData)
            return res.data
        }catch(err){
            // Handle validation errors
            if (err.response && err.response.status === 422) {
                return rejectWithValue({
                    type: 'validation',
                    errors: err.response.data.message
                })
            }
            
            // Handle other errors
            return rejectWithValue({
                type: 'general',
                message: err.message || 'Something went wrong'
            })
        }
    }
)

const initialState = {
    contactForm: {
        data: {},
        validationErrors: null,
        error: null,
        loading: false
    },
    subscribeForm: {
        data: {},
        validationErrors: null,
        error: null,
        loading: false
    }
}

const formSlice = createSlice({
    name: "form",
    initialState,
    reducers: {
        // Extra reducers dışında özel işlemler eklenecekse buraya yazılır
    },
    extraReducers: (builder) => {
        builder
            /* Subscriber Store */
            .addCase(storeSubscriber.pending, (state) => {
                state.subscribeForm.loading = true
                state.subscribeForm.error = null
            })
            .addCase(storeSubscriber.fulfilled, (state, action) => {
                state.subscribeForm.data = action.payload
                state.subscribeForm.loading = false
            })
            .addCase(storeSubscriber.rejected, (state, action) => {
                state.subscribeForm.loading = false
                if (action.payload.type === 'validation') {
                    state.subscribeForm.validationErrors = action.payload.errors;
                } else {
                    state.subscribeForm.error = action.payload.message;
                }
            })
    }
})

export default formSlice.reducer