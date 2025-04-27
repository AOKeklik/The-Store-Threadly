import { createAsyncThunk, createSlice } from "@reduxjs/toolkit"
import axiosClient from "../config"
import { handleActionError, handleError } from "./helpers/errorHandlers"

export const signupSubmit = createAsyncThunk(
    "auth/signup",
    async(formData, {rejectWithValue}) => {
        try{
            await new Promise(resolve => setTimeout(resolve, 1000))
            const res = await axiosClient.post(`/auth/signup`, formData)
            return res.data
        }catch(err){
            return rejectWithValue(handleError(err))
        }
    }
)

export const signinSubmit = createAsyncThunk(
    "auth/signin",
    async(formData, {rejectWithValue}) => {
        try{
            await new Promise(resolve => setTimeout(resolve, 1000))
            const res = await axiosClient.post(`/auth/signin`, formData)
            return res.data
        }catch(err){
            return rejectWithValue(handleError(err))
        }
    }
)

export const resetSubmit = createAsyncThunk(
    "auth/reset",
    async(formData, {rejectWithValue}) => {
        try{
            await new Promise(resolve => setTimeout(resolve, 1000))
            const res = await axiosClient.post(`/auth/reset`, formData)
            return res.data
        }catch(err){
            return rejectWithValue(handleError(err))
        }
    }
)

export const resetVerifySubmit = createAsyncThunk( 
    "auth/reset/verify",
    async(formData, {rejectWithValue}) => {
        try{
            await new Promise(resolve => setTimeout(resolve, 1000))
            const res = await axiosClient.post(`/auth/reset/verify`, formData)
            return res.data
        }catch(err){
            return rejectWithValue(handleError(err))
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

    signin: {
        data: {},
        validationErrors: null,
        error: null,
        loading: false
    },

    reset: {
        data: {},
        validationErrors: null,
        error: null,
        loading: false
    },

    resetVerify: {
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
                handleActionError(state, action, 'signup')
            })

            /* Signin */
            .addCase(signinSubmit.pending, (state) => {
                state.signin.loading = true;
                state.signin.error = null;
                state.signin.validationErrors = null;
            })
            .addCase(signinSubmit.fulfilled, (state, action) => {
                state.signin.data = action.payload
                state.signin.loading = false
            })
            .addCase(signinSubmit.rejected, (state, action) => {
                state.signin.loading = false
                handleActionError(state, action, 'signin')
            })

            /* Reset */
            .addCase(resetSubmit.pending, (state) => {
                state.reset.loading = true;
                state.reset.error = null;
                state.reset.validationErrors = null;
            })
            .addCase(resetSubmit.fulfilled, (state, action) => {
                state.reset.data = action.payload
                state.reset.loading = false
            })
            .addCase(resetSubmit.rejected, (state, action) => {
                state.reset.loading = false
                handleActionError(state, action, 'reset')
            })

            /* Reset Verify */
            .addCase(resetVerifySubmit.pending, (state) => {
                state.resetVerify.loading = true;
                state.resetVerify.error = null;
                state.resetVerify.validationErrors = null;
            })
            .addCase(resetVerifySubmit.fulfilled, (state, action) => {
                state.resetVerify.data = action.payload
                state.resetVerify.loading = false
            })
            .addCase(resetVerifySubmit.rejected, (state, action) => {
                state.resetVerify.loading = false
                handleActionError(state, action, 'resetVerify')
            })
    }
})

export default formSlice.reducer