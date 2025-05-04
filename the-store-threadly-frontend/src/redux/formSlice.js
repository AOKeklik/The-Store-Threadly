import { createAsyncThunk, createSlice } from "@reduxjs/toolkit"
import axiosClient from "../config"

export const storeSubscriber = createAsyncThunk(
    "form/subscriber/store",
    async(formData, {rejectWithValue}) => {
        try{            
            const res = await axiosClient.post(`/form/subscriber/store`, formData)
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

export const storeContact = createAsyncThunk(
    "form/contact/store",
    async(formData, {rejectWithValue}) => {
        try{            
            const res = await axiosClient.post(`/form/contact/store`, formData)
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
    subscribeForm: {
        data: {},
        validationErrors: null,
        error: null,
        loading: false
    },
    contactForm: {
        data: {},
        validationErrors: null,
        error: null,
        loading: false
    },
}

const formSlice = createSlice({
    name: "form",
    initialState,
    reducers: {
        // Extra reducers dışında özel işlemler eklenecekse buraya yazılır
    },
    extraReducers: (builder) => {
        builder
            /* Subscriber */
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

            /* Contact */
            .addCase(storeContact.pending, (state) => {
                state.contactForm.loading = true
                state.contactForm.error = null
            })
            .addCase(storeContact.fulfilled, (state, action) => {
                state.contactForm.data = action.payload
                state.contactForm.loading = false
            })
            .addCase(storeContact.rejected, (state, action) => {
                state.contactForm.loading = false
                if (action.payload.type === 'validation') {
                    state.contactForm.validationErrors = action.payload.errors;
                } else {
                    state.contactForm.error = action.payload.message;
                }
            })
    }
})

export default formSlice.reducer