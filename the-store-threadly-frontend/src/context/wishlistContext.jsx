// src/contexts/WishlistContext.js
import { createContext, useContext, useState, useEffect } from 'react'
import { toast } from 'react-toastify'
import axiosClient from '../config'

const WishlistContext = createContext();

export const WishlistProvider = ({ children }) => {
    const [wishlist, setWishlist] = useState([]);
    const [loading, setLoading] = useState(true);
    const [isAuthenticated, setIsAuthenticated] = useState(false);

    // Check authentication status on initial load
    useEffect(() => {
        const checkAuth = async () => {
            try {
                await axiosClient.get('/user');
                setIsAuthenticated(true);
                fetchWishlist(); // Fetch from server if authenticated
            } catch {
                setIsAuthenticated(false);
                loadGuestWishlist(); // Load from localStorage if guest
            }
        };
        checkAuth();
    }, []);

    // Fetch wishlist from server (authenticated users)
    const fetchWishlist = async () => {
        try {
            const { data } = await axiosClient.get('/api/wishlist');
            setWishlist(data);
        } catch (error) {
            console.error('Error fetching wishlist:', error);
        } finally {
            setLoading(false);
        }
    };

    // Load wishlist from localStorage (guest users)
    const loadGuestWishlist = () => {
        try {
            const guestWishlist = JSON.parse(localStorage.getItem('guestWishlist') || '[]');
            setWishlist(guestWishlist);
        } catch (error) {
            console.error('Error loading guest wishlist:', error);
        } finally {
            setLoading(false);
        }
    };

    // Save guest wishlist to localStorage
    const saveGuestWishlist = (items) => {
        localStorage.setItem('guestWishlist', JSON.stringify(items));
    };

    // Add item to wishlist (handles both auth and guest)
    const addToWishlist = async (product) => {
        if (isAuthenticated) {
            try {
                const { data, message } = await axiosClient.post('/api/wishlist', { 
                    product_id: product.productId 
                });
                setWishlist(prev => [...prev, data]);
                toast.success(message || "Item added to your wishlist");
            } catch (error) {
                console.error('Error adding to wishlist:', error);
                toast.error("Failed to add item to wishlist");
            }
        } else {
            // Guest handling
            const newItem = {
                id: Date.now(),
                user_id: `guest_${Date.now()}`,
                product_id: product.productId,
                product: product
            };
            const updatedWishlist = [...wishlist, newItem];
            setWishlist(updatedWishlist);
            saveGuestWishlist(updatedWishlist);
            toast.success("Item added to your wishlist");
        }
    };

    // Remove item from wishlist (handles both auth and guest)
    const removeFromWishlist = async (wishlistItemId) => {
        if (isAuthenticated) {
            try {
                const { message } = await axiosClient.delete(`/api/wishlist/${wishlistItemId}`);
                setWishlist(prev => prev.filter(item => item.id !== wishlistItemId));
                toast.success(message || "Item removed from your wishlist");
            } catch (error) {
                console.error('Error removing from wishlist:', error);
                toast.error("Failed to remove item from wishlist");
            }
        } else {
            // Guest handling
            const updatedWishlist = wishlist.filter(item => item.id !== wishlistItemId)
            setWishlist(updatedWishlist)
            saveGuestWishlist(updatedWishlist)
            toast.success("Item removed from your wishlist")
        }
    }

    // Check if product is in wishlist
    const isInWishlist = (productId) => {
        return wishlist.some(item => item.product_id === productId)
    }

    // Merge guest wishlist with user wishlist after login
    const mergeGuestWishlist = async () => {
        const guestWishlist = JSON.parse(localStorage.getItem('guestWishlist') || '[]');
        if (guestWishlist.length > 0) {
            try {
                const productIds = guestWishlist.map(item => item.product_id);
                await axiosClient.post('/api/wishlist/merge', { product_ids: productIds });
                localStorage.removeItem('guestWishlist');
                fetchWishlist(); // Refresh the wishlist
            } catch (error) {
                console.error('Error merging wishlist:', error)
            }
        }
    }

    return (
        <WishlistContext.Provider 
            value={{ 
                wishlist, 
                wishlistCount: wishlist.length,
                loading, 
                isAuthenticated,
                addToWishlist, 
                removeFromWishlist,
                isInWishlist,
                isWishlistEmpty: wishlist.length === 0,
                fetchWishlist,
                mergeGuestWishlist
            }}
        >
            {children}
        </WishlistContext.Provider>
    );
};

export const useWishlist = () => useContext(WishlistContext);


//const { wishlistCount } = useWishlist();