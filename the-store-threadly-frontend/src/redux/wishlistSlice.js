import { createSlice, createAsyncThunk } from "@reduxjs/toolkit"
import { axiosProtected } from "../config"

import { handleError } from "../utilities/errorHandlerNew"
import { getWishlistStorage } from "../utilities/storeages"
import { generateUniqueId, isAuthenticated } from "../utilities/helpers"


export const fetchWishlist = createAsyncThunk(
    "wishlist/fetch",
    async (_, { rejectWithValue }) => {
        try {
            if (!isAuthenticated()) {
                return getWishlistStorage()
            }
            const { data: {data} } = await axiosProtected.get("/wishlist")

            return data.map(product => ({
                ...product,
                uniqueId: generateUniqueId(product)
            }))
        } catch (err) {
            return rejectWithValue(handleError(err))
        }
    }
)

export const addToWishlist = createAsyncThunk(
    "wishlist/add",
    async (product, { rejectWithValue }) => {
        try {
            const uniqueId = generateUniqueId(product)

            if (!isAuthenticated()) {
                return {
                    data: { uniqueId, ...product }
                }
            }
    
            const {data} = await axiosProtected.post("/wishlist/store", {
                product_id: product.productId,
                product_variant_id: product.variantId,
            })
        
            return {...data, data: {...data.data, uniqueId}}
        } catch (err) {
            return rejectWithValue(handleError(err))
        }
    }
)

export const removeFromWishlist = createAsyncThunk(
    "wishlist/remove",
    async (product, { rejectWithValue }) => {
        try {
            const uniqueId = generateUniqueId(product)            

            if (!isAuthenticated()) {
                return {
                    data: { uniqueId, ...product }
                }
            }
    
            const {data} = await axiosProtected.delete("/wishlist/delete", {
                data: {
                    product_id: product.productId,
                    product_variant_id: product.variantId,
                },
            })

            return {
                ...data,
                message: data.message,
                data: {...data.data, uniqueId}
            }
        } catch (err) {
            return rejectWithValue(handleError(err))
        }
    }
)

export const clearWishlist = createAsyncThunk(
    "wishlist/clear",
    async (_, { dispatch, rejectWithValue }) => {
        try {
            if(!isAuthenticated()) {
                dispatch(wishlistSlice.actions.clearLocalWishlist())
                return 
            }
            await axiosProtected.delete("/wishlist/clear")
        } catch (err) {
            return rejectWithValue(handleError(err))
        }
    }
)

// Initial State
export const initialState = {
    local: {
        items: [],
        loadingItems: [],
        count: 0,
        status: "idle", // 'idle' | 'loading' | 'succeeded' | 'failed'
        error: null,
    },

    operations: {
        add: { data: [], loading: false, error: null },
        remove: { data: {}, loading: false, error: null },
        clear: { data: {}, loading: false, error: null },
    },
}

const wishlistSlice = createSlice({
    name: "wishlist",
    initialState,
    reducers: {
        clearLocalWishlist: (state) => {
            state.local = initialState.local
        },
        addToLocalWishlist: (state, action) => {
            const newItem = action.payload.data

            if (!state.local.items.some(item => item.uniqueId === newItem.uniqueId)) {
                state.local.items.push(newItem)
                state.local.count = state.local.items.length
            }
        },
        removeFromLocalWishlist: (state, action) => {
            const {uniqueId} = action.payload.data

            state.local.items = state.local.items.filter(item => item.uniqueId !== uniqueId)
            state.local.count = state.local.items.length
        },
        
        /* Loading Items */
        setLoadingItems: (state, action) => {
            const uniqueId = generateUniqueId(action.meta.arg)
            state.local.loadingItems.push(uniqueId)
        },
        removeFromLoadingItems: (state, action) => {
            const uniqueId = action.payload?.data?.uniqueId || action.payload?.uniqueId
            
            if (uniqueId) {
                state.local.loadingItems = state.local.loadingItems.filter(id => id !== uniqueId)
            }
        }
    },
    extraReducers: (builder) => {
        builder
            /* Fetch */
            .addCase(fetchWishlist.pending, (state) => {
                state.local.status = "loading"                
            })
            .addCase(fetchWishlist.fulfilled, (state, action) => {
                state.local.status = "succeeded"
                state.local.items = action.payload
                state.local.count = action.payload.length
            })
            .addCase(fetchWishlist.rejected, (state, action) => {
                state.local.status = "failed"
                state.local.error = action.payload
            })

            /* Add */
            .addCase(addToWishlist.pending, (state, action) => {
                state.operations.add = {
                    ...initialState.operations.add,
                    loading: true,
                }
                
                wishlistSlice.caseReducers.setLoadingItems(state, action)
            })
            .addCase(addToWishlist.fulfilled, (state, action) => {
                state.operations.add = {
                    ...initialState.operations.add,
                    data: action.payload
                }
                
                wishlistSlice.caseReducers.addToLocalWishlist(state, action)
                wishlistSlice.caseReducers.removeFromLoadingItems(state, action)
            })
            .addCase(addToWishlist.rejected, (state, action) => {
                state.operations.add = {
                    ...initialState.operations.add,
                    error: action.payload
                }

                wishlistSlice.caseReducers.removeFromLoadingItems(state, action)
            })
            

            /* Remove */
            .addCase(removeFromWishlist.pending, (state, action) => {
                state.operations.remove = {
                    ...initialState.operations.remove,
                    loading: true,
                }

                wishlistSlice.caseReducers.setLoadingItems(state, action)
            })
            .addCase(removeFromWishlist.fulfilled, (state, action) => {
                state.operations.remove = {
                    ...initialState.operations.remove,
                    data: action.payload
                }


                wishlistSlice.caseReducers.removeFromLocalWishlist(state, action)
                wishlistSlice.caseReducers.removeFromLoadingItems(state, action)
            })
            .addCase(removeFromWishlist.rejected, (state, action) => {
                state.operations.remove = {
                    ...initialState.operations.remove,
                    error: action.payload
                }

                wishlistSlice.caseReducers.removeFromLoadingItems(state, action)
            })

            /* Clear */
            .addCase(clearWishlist.pending, (state) => {
                state.operations.clear = {
                    ...initialState.operations.clear,
                    loading: true,
                }
            })
            .addCase(clearWishlist.fulfilled, (state, action) => {
                state.operations.clear = {
                    ...initialState.operations.clear,
                    data: action.payload,
                }

                wishlistSlice.caseReducers.clearLocalWishlist (state)
            })
            .addCase(clearWishlist.rejected, (state, action) => {
                state.operations.clear = initialState.clear
            })
    },
})

export default wishlistSlice.reducer
