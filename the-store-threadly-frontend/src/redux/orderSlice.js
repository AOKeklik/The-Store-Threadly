import { createAsyncThunk, createSlice } from "@reduxjs/toolkit"
import { axiosProtected } from "../config"
import { handleError } from '../utilities/errorHandlerNew'
import { getCartStorage } from "../utilities/storeages"
import { setCoupon, setSelectedDelivery } from "./cartSlice"

    export const fetchDeliveryMethods = createAsyncThunk(
        "order/delivery/fetch",
        async(_, {dispatch, rejectWithValue}) => {
            try{
                const res = await axiosProtected.post(`/order/delivery/fetch`)
                const data = res.data.data
                // const messsage = res.data.message

                if (data?.length > 0) {
                    const storedDelivery = getCartStorage()?.selectedDelivery

                    if (!storedDelivery) {
                        await dispatch(setSelectedDelivery(data.at(-1)))
                    }
                }

                return data
            }catch(err){
                return rejectWithValue(handleError(err))
            }
        }
    )

	export const submitCoupon = createAsyncThunk(
	    "order/coupon/submit",
	    async(formData, {dispatch, rejectWithValue}) => {
	        try{
	            const {data} = await axiosProtected.post(`/order/coupon/submit`, formData)
                await dispatch(setCoupon(data.data))
                
	            return data
	        }catch(err){
	            return rejectWithValue(handleError(err))
	        }
	    }
	)

	const initialState = {        
        delivery: {
            data: [],
            loading: false,
            error: null,
        },

	    coupon: {
            data: {},
            loading: false,
            error: null,
            validationErrors: null,
        }
	}

	const orderSlice = createSlice({
	    name: "order",
	    initialState,
	    reducers: {},
	    extraReducers: (builder) => {
	        builder
                /* Delivery Methods Fetch */
                .addCase(fetchDeliveryMethods.pending, (state) => {
                    state.delivery = {
                        ...initialState.delivery,
                        loading: true,
                    }
                })
                .addCase(fetchDeliveryMethods.fulfilled, (state, action) => {
                    state.delivery = {
                        ...initialState.delivery,
                        data: action.payload,
                    }
                })
                .addCase(fetchDeliveryMethods.rejected, (state, action) => {
                    state.delivery = {
                        ...initialState.delivery,
                        error: action.payload.message
                    }
                })


	            /* Coupon Submit */
	            .addCase(submitCoupon.pending, (state) => {
                    state.coupon = {
                        ...initialState.coupon,
                        loading: true,
                    }
	            })
	            .addCase(submitCoupon.fulfilled, (state, action) => {
                    state.coupon = {
                        ...initialState.coupon,
                        data: action.payload,
                    }
	            })
	            .addCase(submitCoupon.rejected, (state, action) => {
                    state.coupon = {
                        ...initialState.coupon,
                    }

                    if (action.payload.type === 'validation') {
                        state.coupon.validationErrors = action.payload.errors;
                    } else {
                        state.coupon.error = action.payload.message;
                    }
	            })
	    }
	})

	export default orderSlice.reducer