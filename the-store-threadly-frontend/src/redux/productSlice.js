// features/product/productsSlice.js
import { createSlice, createAsyncThunk } from '@reduxjs/toolkit';
import axiosClient from '../config';


const arangedData = (filteredData) => filteredData?.data.flatMap(product => {
    // Eğer varyant varsa, sadece ilk varyantı döndür
    if (product.variants?.length > 0) {
        /* Varsa indirimli, yoksa ilk variant */
        const variant = product.variants.find(v => v.offer_price) || product.variants[0]
        const attributes = variant.attributes?.reduce((acc, attr) => {
            if (attr.attribute.slug === "color") {
                acc.color = {
                    value: attr.value,
                    icon: attr.icon,
                    slug: attr.slug,
                };
            } else if (attr.attribute.slug === "size") {
                acc.size = {
                    value: attr.value,
                    icon: attr.icon,
                    slug: attr.slug,
                };
            }
            return acc;
        }, { color: null, size: null });

        return [{
            productId: product.id,     
            variantId: variant.id,
            isVariant: true,
            slug: product.slug,
            title: product.title,
            short_desc: product.short_desc,
            price: variant.offer_price ? variant.offer_price : variant.price,
            base_price: variant.price,
            offer_price: variant.offer_price,
            price_html: variant.price_html,
            stock: variant.stock,
            thumbnail: variant.thumbnail,
            cover: product.cover,
            galeries: variant.galeries?.length > 0 ? variant.galeries : product.galeries,
            category: {
                name: product.category?.name,
                slug: product.category?.slug,
            },
            color: attributes.color,
            size: attributes.size,
            gender: product.gender,
            is_new: product.is_new,
            is_featured: product.is_featured,
            is_best_seller: product.is_best_seller, 
        }];
    }

    // Varyant yoksa ürünün kendisini döndür
    return [{
        productId: product.id,     
        variantId: null,
        isVariant: false,
        slug: product.slug,
        title: product.title,
        short_desc: product.short_desc,
        price: product.offer_price ? product.offer_price : product.price,
        offer_price: product.offer_price,
        price_html: product.price_html,
        stock: product.stock,
        thumbnail: product.thumbnail,
        cover: product.cover,
        galeries: product.galeries,
        category: {
            name: product.category?.name,
            slug: product.category?.slug,
        },
        color: null,
        size: null,
        gender: product.gender,
        is_new: product.is_new,
        is_featured: product.is_featured,
        is_best_seller: product.is_best_seller,         
    }];
}) || []


export const fetchAllProducts = createAsyncThunk(
    'product/fetchAll',
    async (_, { rejectWithValue }) => {
        try {
            await new Promise(resolve => setTimeout(resolve, 1000))
            const response = await axiosClient.get("/product/all");
            return response.data
        } catch (err) {
            return rejectWithValue(err.response?.data || err.message)
        }
    }
)


export const fetchFilteredProducts = createAsyncThunk(
    'product/fetchFiltered',
    async (filters, { rejectWithValue }) => {
        try {
            const query = new URLSearchParams();
            if (filters.color) query.append("color", filters.color)
            if (filters.size) query.append("size", filters.size)
            if (filters.gender) query.append("gender", filters.gender)
            if (filters.category) query.append("category", filters.category)
            if (filters.page) query.append("page", filters.page)

            await new Promise(resolve => setTimeout(resolve, 1000))
            const response = await axiosClient.get(`/product/filter?${query.toString()}`)
            return response.data
        } catch (error) {
            return rejectWithValue(error.response?.data || error.message)
        }
    }
)


export const fetchFeaturedProducts = createAsyncThunk(
    'product/fetchFeatured',
    async (_, { rejectWithValue }) => {
        try {
            await new Promise(resolve => setTimeout(resolve, 1000))
            const response = await axiosClient.get(`/product/all/featured`)
            return response.data
        } catch (err) {
            return rejectWithValue(err.response?.data || err.message)
        }
    }
)

export const fetchOneProduct = createAsyncThunk(
    "product/fetchOne",
    async(slug, {rejectWithValue}) => {
        try{
            await new Promise(resolve => setTimeout(resolve, 1000))
            const res = await axiosClient.get(`/product/${slug}`)
            console.log(res)
            return res.data
        }catch(err){
            return rejectWithValue(err.response?.data || err.message)
        }
    }
)


const initialState = {
   /* PRODUCT ALL */
    data: [],
    loading: false,
    error: null,

    /* PRODUCT ONE */
    dataProduct: {},
    dataRelatedProduct: [],
    loadingProduct: true,
    errorProduct: null,

    /* PRODUCT FILTERED */
    dataFilteredProduct: [],
    metaFilteredProduct: {},
    loadingFilteredProduct: true,
    errorFilteredProduct: null,

    /* PRODUCT FEATURED */
    featuredData: [],
    loadingFeatured: false,
    errorFeatured: null,
};

const productSlice = createSlice({
    name: 'product',
    initialState,
    reducers: {
        // Extra reducers dışında özel işlemler eklenecekse buraya yazılır
    },
    extraReducers: (builder) => {
        builder

            /* ////////// PRODUCT ALL ////////// */
            .addCase(fetchAllProducts.pending, (state) => {
                state.loading = true
                state.error = null
            })
            .addCase(fetchAllProducts.fulfilled, (state, action) => {
                state.data = arangedData(action.payload)
                state.loading = false
            })
            .addCase(fetchAllProducts.rejected, (state, action) => {
                state.loading = false
                state.error = action.payload || 'Bir hata oluştu'
            })

            /* ////////// PRODUCT ONE ////////// */
            .addCase(fetchOneProduct.pending, (state) => {
                state.loadingProduct = true
                state.errorProduct = null
            })
            .addCase(fetchOneProduct.fulfilled, (state, action) => {
                const {data,dataRelated} = action.payload

                state.dataProduct = data
                state.dataRelatedProduct=dataRelated
                state.loadingProduct = false
            })
            .addCase(fetchOneProduct.rejected, (state, action) => {
                state.loadingProduct = false
                state.errorProduct = action.payload || 'Bir hata oluştu'
            })

            /* ////////// PRODUCT FILTERED ////////// */
            .addCase(fetchFilteredProducts.pending, (state) => {
                state.loadingFilteredProduct = true;
                state.errorFilteredProduct = null;
            })
            .addCase(fetchFilteredProducts.fulfilled, (state, action) => {
                const {data, meta} = action.payload
                state.dataFilteredProduct = arangedData(action.payload)
                state.metaFilteredProduct = meta
                state.loadingFilteredProduct = false;
            })
            .addCase(fetchFilteredProducts.rejected, (state, action) => {
                state.loadingFilteredProduct = false;
                state.errorFilteredProduct = action.payload || 'Bir hata oluştu';
            })

            /* ////////// PRODUCT FEAUTRED ////////// */
            .addCase(fetchFeaturedProducts.pending, (state) => {
                state.loadingFeatured = true;
                state.errorFeatured = null;
            })
            .addCase(fetchFeaturedProducts.fulfilled, (state, action) => {
                state.featuredData = arangedData(action.payload)
                state.loadingFeatured = false;
            })
            .addCase(fetchFeaturedProducts.rejected, (state, action) => {
                state.loadingFeatured = false;
                state.errorFeatured = action.payload || 'Bir hata oluştu';
            })
    },
})

export default productSlice.reducer;
