import { createSlice, createAsyncThunk } from "@reduxjs/toolkit"
import { axiosProtected } from "../config"
import { handleError } from "../utilities/errorHandlerNew"
import generateUniqueId from "../utilities/generateUniqueId"

// Yardımcı: Giriş kontrolü
const isAuthenticated = () => {
    return typeof window !== "undefined" && !!localStorage.getItem("user")
}

// Yardımcı: LocalStorage wishlist verisini al
const getLocalWishlist = () => {
    try {
        const data = JSON.parse(localStorage.getItem("wishlist"))
        return data?.items || []
    } catch {
        return []
    }
}

export const fetchWishlist = createAsyncThunk(
    "wishlist/fetch",
    async (_, { rejectWithValue }) => {
        try {
            if (!isAuthenticated()) {
                return getLocalWishlist()
            }
            const { data: {data} } = await axiosProtected.get("/wishlist")

            const processedData = data.map(product => ({
                ...product,
                uniqueId: generateUniqueId(product)
            }))

            return processedData
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

            await new Promise(resolve => setTimeout(resolve, 10000))
    
            if (!isAuthenticated()) {
                return { data: { uniqueId, ...product }}
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

            await new Promise(resolve => setTimeout(resolve, 1000))

            if (!isAuthenticated()) {
                return { data: { uniqueId, ...product }}
            }
    
            const {data} = await axiosProtected.delete("/wishlist/delete", {
                data: {
                    product_id: product.productId,
                    product_variant_id: product.variantId,
                },
            })

            return {...data, data: {...data.data, uniqueId}}
        } catch (err) {
            return rejectWithValue(handleError(err))
        }
    }
)

export const clearWishlist = createAsyncThunk(
    "wishlist/clear",
    async (_, { dispatch, rejectWithValue }) => {
        try {

            await new Promise(resolve => setTimeout(resolve, 1000))

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
const initialState = {
    items: [],
    count: 0,
    status: "idle", // 'idle' | 'loading' | 'succeeded' | 'failed'
    error: null,

    loadingItems: [],

    add: {
        data: {},
        loading: false,
        error: null,
    },
    remove: {
        data: {},
        loading: false,
        error: null,
    },
    clear: {
        data: {},
        loading: false,
        error: null,
    },
}

const wishlistSlice = createSlice({
    name: "wishlist",
    initialState,
    reducers: {
        clearLocalWishlist: (state) => {
            state.items = []
            state.loadingItems = []
            state.count = 0
            state.error = null
        },
        addToLocalWishlist: (state, action) => {
            const newItem = action.payload.data

            if (!state.items.some(item => item.uniqueId === newItem.uniqueId)) {
                state.items.push(newItem)
                state.count = state.items.length
            }
        },
        removeFromLocalWishlist: (state, action) => {
            const deletedItem = action.payload.data

            state.items = state.items.filter(item => item.uniqueId !== deletedItem.uniqueId)
            state.count = state.items.length
        },
        
        /* Loading Items */
        setLoadingItems: (state, action) => {
            const item = action.meta.arg
            const uniqueId = generateUniqueId(item)
            
            state.loadingItems.push(uniqueId)
        },
        removeFromLoadingItems: (state, action) => {
            const uniqueId = action.payload?.data?.uniqueId || action.payload?.uniqueId
            
            if (uniqueId) {
                state.loadingItems = state.loadingItems.filter(item => item !== uniqueId)
            }
        }
    },
    extraReducers: (builder) => {
        builder
            /* Fetch */
            .addCase(fetchWishlist.pending, (state) => {
                state.status = "loading"
            })
            .addCase(fetchWishlist.fulfilled, (state, action) => {
                state.status = "succeeded"
                state.items = action.payload
                state.count = action.payload.length
            })
            .addCase(fetchWishlist.rejected, (state, action) => {
                state.status = "failed"
                state.error = action.payload
            })

            /* Add */
            .addCase(addToWishlist.pending, (state, action) => {
                state.add = {
                    ...state.add,
                    loading: true,
                    error: null
                }
                
                wishlistSlice.caseReducers.setLoadingItems(state, action)
            })
            .addCase(addToWishlist.fulfilled, (state, action) => {
                state.add = {
                    ...state.add,
                    loading: false,
                    data: action.payload
                }

                console.log(state)
                
                wishlistSlice.caseReducers.addToLocalWishlist(state, action)
                wishlistSlice.caseReducers.removeFromLoadingItems(state, action)
            })
            .addCase(addToWishlist.rejected, (state, action) => {
                state.add = {
                    ...state.add,
                    loading: false,
                    error: action.payload
                }

                wishlistSlice.caseReducers.removeFromLoadingItems(state, action)
            })
            

            /* Remove */
            .addCase(removeFromWishlist.pending, (state, action) => {
                state.remove = {
                    ...state.remove,
                    loading: true,
                    error: null
                }

                wishlistSlice.caseReducers.setLoadingItems(state, action)
            })
            .addCase(removeFromWishlist.fulfilled, (state, action) => {
                state.remove = {
                    ...state.remove,
                    loading: false,
                    data: action.payload
                }

                wishlistSlice.caseReducers.removeFromLocalWishlist(state, action)
                wishlistSlice.caseReducers.removeFromLoadingItems(state, action)
            })
            .addCase(removeFromWishlist.rejected, (state, action) => {
                state.remove = {
                    ...state.remove,
                    loading: false,
                    error: action.payload
                }

                wishlistSlice.caseReducers.removeFromLoadingItems(state, action)
            })

            /* Clear */
            .addCase(clearWishlist.pending, (state) => {
                state.clear = {
                    ...state.clear,
                    loading: true,
                    error: null
                }
            })
            .addCase(clearWishlist.fulfilled, (state, action) => {
                state.clear = {
                    ...state.clear,
                    data: action.payload,
                    loading: false,
                    error: null
                }

                wishlistSlice.caseReducers.clearLocalWishlist (state)
            })
            .addCase(clearWishlist.rejected, (state, action) => {
                state.clear = {
                    ...state.clear,
                    data: action.payload,
                    loading: false,
                    error: action.payload
                }
            })
    },
})

export default wishlistSlice.reducer
