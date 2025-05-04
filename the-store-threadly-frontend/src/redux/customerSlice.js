import { createAsyncThunk, createSlice } from "@reduxjs/toolkit"
import { axiosProtected } from "../config"
import { handleError } from './../utilities/errorHandlerNew'

	export const fetchProfile = createAsyncThunk(
	    "customer/profile/fetch",
	    async(_, {rejectWithValue}) => {
	        try{	            
	            const res = await axiosProtected.get(`/customer/profile`)
	            return res.data
	        }catch(err){
	            return rejectWithValue(handleError(err))
	        }
	    }
	)

    export const updateProfile = createAsyncThunk(
	    "customer/profile/update",
	    async(formData, {rejectWithValue}) => {
	        try{	            
	            const res = await axiosProtected.post(`/customer/profile/update`, formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                })
	            return res.data
	        }catch(err){
	            return rejectWithValue(handleError(err))
	        }
	    }
	)

    export const updatePassword = createAsyncThunk(
	    "customer/password/update",
	    async(formData, {rejectWithValue}) => {
	        try{
	            const res = await axiosProtected.post(`/customer/password/update`, formData)
	            return res.data
	        }catch(err){
	            return rejectWithValue(handleError(err))
	        }
	    }
	)

    export const updateAddress = createAsyncThunk(
	    "customer/address/update",
	    async(formData, {rejectWithValue}) => {
	        try{	            
	            const res = await axiosProtected.post(`/customer/address/update`, formData)
	            return res.data
	        }catch(err){
	            return rejectWithValue(handleError(err))
	        }
	    }
	)

	const initialState = {
	    profile: {
	        fetch: {
                data: {},
                error: null,
                loading: false
            },

            update: {
                data: {},
	            error: null,
                validationErrors: null,
	            loading: false
            }
	    },

        password: {
            data: {},
            error: null,
            validationErrors: null,
            loading: false
	    },

        address: {
            data: {},
            error: null,
            validationErrors: null,
            loading: false
	    },

	}

	const customerSlice = createSlice({
	    name: "customer",
	    initialState,
	    reducers: {
	        // Extra reducers dışında özel işlemler eklenecekse buraya yazılır
	    },
	    extraReducers: (builder) => {
	        builder
	            /* Profile Fetch */
	            .addCase(fetchProfile.pending, (state) => {
                    state.profile.fetch = {
                        ...state.profile.fetch,
                        data: {},
                        loading: true,
                        error: null,
                    }
	            })
	            .addCase(fetchProfile.fulfilled, (state, action) => {
                    state.profile.fetch = {
                        ...state.profile.fetch,
                        data: action.payload.data,
                        loading: false,
                        error: null,
                    }
	            })
	            .addCase(fetchProfile.rejected, (state, action) => {
                    state.profile.fetch = {
                        ...state.profile.fetch,
                        data: {},
                        loading: false,
                        error: action.payload,
                    }
	            })


                /* Profile Update */
	            .addCase(updateProfile.pending, (state) => {
                    state.profile.update = {
                        ...state.profile.update,
                        data: {},
                        loading: true,
                        error: null,
                        validationErrors: null,
                    }
	            })
	            .addCase(updateProfile.fulfilled, (state, action) => {
                    state.profile.update = {
                        ...state.profile.update,
                        data: action.payload.data,
                        loading: false,
                        error: null,
                        validationErrors: null,
                    }
	            })
	            .addCase(updateProfile.rejected, (state, action) => {
                    if(action.payload.type === "validation")
                        state.profile.update = {
                            ...state.profile.update,
                            data: {},
                            loading: false,
                            validationErrors: action.payload,
                            error: null,
                        }
                    else
                        state.profile.update = {
                            ...state.profile.update,
                            data: {},
                            loading: false,
                            validationErrors: null,
                            error: action.payload,
                        }
	            })

                /* PAssword Update */
	            .addCase(updatePassword.pending, (state) => {
                    state.password = {
                        ...state.password,
                        data: {},
                        loading: true,
                        error: null,
                        validationErrors: null,
                    }
	            })
	            .addCase(updatePassword.fulfilled, (state, action) => {
                    state.password = {
                        ...state.password,
                        data: action.payload.data,
                        loading: false,
                        error: null,
                        validationErrors: null,
                    }
	            })
	            .addCase(updatePassword.rejected, (state, action) => {
                    if(action.payload.type === "validation")
                        state.password = {
                            ...state.password,
                            data: {},
                            loading: false,
                            validationErrors: action.payload,
                            error: null,
                        }
                    else
                        state.password = {
                            ...state.password,
                            data: {},
                            loading: false,
                            validationErrors: null,
                            error: action.payload,
                        }
	            })


                /* Address Update */
	            .addCase(updateAddress.pending, (state) => {
                    state.address = {
                        ...state.address,
                        data: {},
                        loading: true,
                        error: null,
                        validationErrors: null,
                    }
	            })
	            .addCase(updateAddress.fulfilled, (state, action) => {
                    state.address = {
                        ...state.address,
                        data: action.payload.data,
                        loading: false,
                        error: null,
                        validationErrors: null,
                    }
	            })
	            .addCase(updateAddress.rejected, (state, action) => {
                    if(action.payload.type === "validation")
                        state.address = {
                            ...state.address,
                            data: {},
                            loading: false,
                            validationErrors: action.payload,
                            error: null,
                        }
                    else
                        state.address = {
                            ...state.address,
                            data: {},
                            loading: false,
                            validationErrors: null,
                            error: action.payload,
                        }
	            })
	    }
	})

	export default customerSlice.reducer