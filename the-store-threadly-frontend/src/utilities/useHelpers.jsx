import React from 'react'
import { useSettings } from "../context/settingContext"
import { getCartStorage } from './storeages'

export default function useHelpers() {
    const { settings } = useSettings ()

    const formatedPrice = (price) => {
        const numericPrice = parseFloat(price)

        return settings.site_currency_icon_position === "right"
            ? numericPrice.toFixed(2) + " " + settings.site_currency_icon
            : settings.site_currency_icon + " " + numericPrice.toFixed(2)
    }

    const getItemPrice = (product) => {
        const price = Number(product.price)
        return formatedPrice (price)
    }

    const getSubTotalPrice = () => {    
        const price = getCartStorage()?.totalPrice || 0
        return formatedPrice(price)
    }
    
    const getTotalPrice = () => {    
        const totalPrice = parseFloat(getCartStorage()?.totalPrice || 0)
        const discountAmuont = parseFloat(getCartStorage()?.coupon?.discountRaw || 0)
        const deliveryPrice = parseFloat(getCartStorage()?.selectedDelivery?.price || 0)
    
        const price = (totalPrice - discountAmuont) + deliveryPrice
    
        return formatedPrice(price)
    }

    const getDeliveryPrice = () => {    
        const price = getCartStorage()?.selectedDelivery?.price || 0
        return formatedPrice(price)
    }

    const getDiscountAmount = () => {    
        const amount = getCartStorage()?.coupon?.discount || formatedPrice(0)
        return amount
    }

    return {
        formatedPrice,

        getItemPrice,
        getSubTotalPrice,
        getTotalPrice,
        getDeliveryPrice,
        getDiscountAmount,
    }
}
