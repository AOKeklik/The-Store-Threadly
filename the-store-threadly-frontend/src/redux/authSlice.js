import { createAsyncThunk, createSlice } from "@reduxjs/toolkit"
import axiosClient, { axiosProtected } from "../config"
import { handleActionError, handleError } from "../utilities/errorHandlers"

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

export const checkAuth = createAsyncThunk(
    'auth/check', 
    async (_, { rejectWithValue }) => {
        try {
            await new Promise(resolve => setTimeout(resolve, 1000))
            const res = await axiosProtected.get('/auth/check')
            return res.data
        } catch (err) {
            return rejectWithValue(handleError(err))
        }
})

export const logout = createAsyncThunk(
    'auth/logout', 
    async (_, { rejectWithValue }) => {
        try {
            await new Promise(resolve => setTimeout(resolve, 1000))
            const res = await axiosProtected.get('/auth/signout');
            return res.data
        } catch (err) {
            return rejectWithValue(handleError(err))
        }
})

const initialState = {
    auth: {
        isAuthenticated: false,
        authChecked: false
    },

    user: {
        user: {},
        token: null,
        tokenType: null,
    },

    logout: {
        data: {},
        loading: false,
        error: null,
    },

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

const authSlice = createSlice({
    name: "auth",
    initialState,
    reducers: {
        setUser: (state, action) => {
            state.user = {
                user: action.payload.user || action.payload,
                token: action.payload.token,
                tokenType: action.payload.tokenType || 'Bearer'
            }

            state.auth.isAuthenticated = true

            localStorage.setItem("user", JSON.stringify(state.user))
        },
        clearUser: (state) => {
            state.user.user = {}
            state.user.token = null
            state.user.tokenType = null

            state.auth.isAuthenticated = false
            // state.auth.authChecked = false

            localStorage.removeItem('user')
        }
    },
    extraReducers: (builder) => {
        builder
            /* Auth Check */
            .addCase(checkAuth.pending, (state) => {
                state.auth.isAuthenticated = false
                state.auth.authChecked = false
            })
            .addCase(checkAuth.fulfilled, (state, action) => {
                state.auth.authChecked = true

                authSlice.caseReducers.setUser(state, action)
            })
            .addCase(checkAuth.rejected, (state) => {
                state.auth.isAuthenticated = false
                state.auth.authChecked = true

                authSlice.caseReducers.clearUser(state)
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

                authSlice.caseReducers.setUser(state, action)
            })
            .addCase(signinSubmit.rejected, (state, action) => {
                state.signin.loading = false
                handleActionError(state, action, 'signin')
            })

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

            /* Logout */
            .addCase(logout.pending, (state) => {
                state.logout.loading = true
                state.logout.error = null
            })
            .addCase(logout.fulfilled, (state, action) => {
                state.logout.loading = false;
                state.logout.data = action.payload

                authSlice.caseReducers.clearUser(state)
            })
            .addCase(logout.rejected, (state, action) => {
                state.logout.loading = false

                handleActionError(state, action, 'logout')
                authSlice.caseReducers.clearUser(state)
            })
    }       
})

export default authSlice.reducer