import { createAsyncThunk, createSlice } from "@reduxjs/toolkit"
import axiosClient from "../config"

export const signupSubmit = createAsyncThunk(
    "auth/signup",
    async(formData, {rejectWithValue}) => {
        try{
            await new Promise(resolve => setTimeout(resolve, 1000))
            const res = await axiosClient.post(`/auth/signup`, formData)
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
    signup: {
        data: {},
        validationErrors: null,
        error: null,
        loading: false
    },
}

const formSlice = createSlice({
    name: "auth",
    initialState,
    reducers: {
        // Extra reducers dışında özel işlemler eklenecekse buraya yazılır
    },
    extraReducers: (builder) => {
        builder
            /* Signup */
            .addCase(signupSubmit.pending, (state) => {
                state.signup.loading = true;
                state.signup.error = null;
                state.signup.validationErrors = null;
            })
            .addCase(signupSubmit.fulfilled, (state, action) => {
                state.signup.data = action.payload
                state.signup.loading = false
            })
            .addCase(signupSubmit.rejected, (state, action) => {
                state.signup.loading = false
                if (action.payload.type === 'validation') {
                    state.signup.validationErrors = action.payload.errors;
                } else {
                    state.signup.error = action.payload.message;
                }
            })
    }
})

export default formSlice.reducer