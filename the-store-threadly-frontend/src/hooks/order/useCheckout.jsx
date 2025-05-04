import { useEffect } from 'react'
import { useDispatch, useSelector } from 'react-redux'
import { toast } from 'react-toastify'

import { fetchDeliveryMethods } from '../../redux/orderSlice'
import { setSelectedDelivery } from '../../redux/cartSlice'
import useHelpers from '../../utilities/useHelpers'

export default function useCheckout() {
    const dispatch = useDispatch()

    const {
        getSubTotalPrice,
        getDeliveryPrice,
        getDiscountAmount,
        getTotalPrice,
    } = useHelpers()

    const { selectedDelivery } = useSelector(state => state.cart)
    const { data, laoding, error } = useSelector(state => state.order.delivery)

    useEffect(() => {
        const loadWishlist = async () => {
            try {
                await dispatch(fetchDeliveryMethods()).unwrap()
            } catch (err) {
                toast.error(err || "Failed to load delivery methods")
            }
        }
        
        loadWishlist()
    }, [dispatch])

    const handleChange = (e) => {
        try {
            const { value } = e.target
            const deliveryMethod = data.find(item => item.id == value)
            if(deliveryMethod) {
                dispatch(setSelectedDelivery(deliveryMethod))
                toast.success("Delivery method selected successfully.")
            }
        } catch (err) {
            console.log("Delivery Submit: ", err)
        }
    }

    const isSelectedDeliveryMethod = (id) => {
        return selectedDelivery?.id === id;
    }

    // console.log(selectedDelivery)

    return {
        isSelectedDeliveryMethod,
        handleChangeDelivery:handleChange,

        deliveryMethods: data,
        isLoadingDeliveryMethods: laoding,

        
        getSubTotalPrice,
        getDeliveryPrice,
        getDiscountAmount,
        getTotalPrice
    }
}
