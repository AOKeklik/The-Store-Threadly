import { useSelector, useDispatch } from "react-redux"
import { useEffect } from "react"
import { toast } from "react-toastify"
import { fetchProfile } from "../../redux/customerSlice"


export default function useProfile() {
    const dispatch = useDispatch()
    
    const { 
        data, 
        loading
    } = useSelector((state) => state.customer.profile.fetch)

    useEffect(() => {
        const loadWishlist = async () => {
            try {
                await dispatch(fetchProfile()).unwrap()
            } catch (err) {
                toast.error(err || "Failed to load wishlist")
                console.error("Profile load error:", err)
            }
        }
        
        loadWishlist()
    }, [dispatch])

    return {
        profile: data,
        isLoadingProfile: loading,
    }
}