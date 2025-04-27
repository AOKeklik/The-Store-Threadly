import { createSlice, createAsyncThunk } from "@reduxjs/toolkit";
import axiosClient from "../config";
import { toast } from "react-toastify";

// Yardımcı: Giriş kontrolü
const isAuthenticated = () => {
    if (typeof window === "undefined") return false;
    return !!localStorage.getItem("token");
};

// Yardımcı: LocalStorage wishlist verisini al
const getLocalWishlist = () => {
    try {
        const data = JSON.parse(localStorage.getItem("wishlist"));
        return data?.items || [];
    } catch {
        return [];
    }
}

const generateUniqueId = (product) => {
    if (!product.variantId) {
        return `product-id-${product.productId}`
    }

    return `product-id-${product.productId}_variant-id-${product.variantId}`
}

export const fetchWishlistAPI = createAsyncThunk(
    "wishlist/fetchAll",
    async (_, { rejectWithValue }) => {
        try {
            if (!isAuthenticated()) {
                return getLocalWishlist();
            }
            const res = await axiosClient.get("/wishlist/all");
            return res.data;
        } catch (err) {
            return rejectWithValue(err.response?.data || err.message);
        }
    }
);

export const addToWishlistAPI = createAsyncThunk(
    "wishlist/add",
    async (product, { rejectWithValue }) => {
        try {
            const uniqueId = generateUniqueId(product)

            if (!isAuthenticated()) {
                const newItem = {
                    uniqueId,
                    ...product,
                }         
                return newItem;
            }

            const res = await axiosClient.post("/wishlist", {
                product_id: product.productId,
            });
            return res.data;
        } catch (err) {
            return rejectWithValue(err.response?.data || err.message);
        }
    }
);

export const removeFromWishlistAPI = createAsyncThunk(
    "wishlist/remove",
    async (product, { rejectWithValue }) => {
        try {
            const uniqueId = generateUniqueId(product)

            if (!isAuthenticated()) {
                return uniqueId
            }

            await axiosClient.delete(`/wishlist/${uniqueId}/`);
            return uniqueId;
        } catch (err) {
            return rejectWithValue(err.response?.data || err.message);
        }
    }
);

// Initial State
const initialState = {
    items: [],
    quantity: 0,
    loading: false,
    error: null,
};

const wishlistSlice = createSlice({
    name: "wishlist",
    initialState,
    reducers: {
        clearWishlist: (state) => {
            state.items = [];
            state.quantity = 0;
            state.error = null;

            /* toast */ 
            toast.info("All items have been removed from your wishlist.")
        },
    },
    extraReducers: (builder) => {
        builder
            .addCase(fetchWishlistAPI.pending, (state) => {
                state.loading = true;
            })
            .addCase(fetchWishlistAPI.fulfilled, (state, action) => {
                state.items = action.payload;
                state.quantity = action.payload.length;
                state.loading = false;
            })
            .addCase(fetchWishlistAPI.rejected, (state, action) => {
                state.loading = false;
                state.error = action.payload;
            })
            .addCase(addToWishlistAPI.fulfilled, (state, action) => {
                state.items.push(action.payload);
                state.quantity++;
            })
            .addCase(removeFromWishlistAPI.fulfilled, (state, action) => {
                state.items = state.items.filter(item => item.uniqueId !== action.payload);
                state.quantity = state.items.length;
            });
    },
});

export const { clearWishlist } = wishlistSlice.actions;
export default wishlistSlice.reducer;
