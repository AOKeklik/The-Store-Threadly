import { useSelector, useDispatch } from "react-redux"
import { useEffect } from "react"
import { toast } from "react-toastify"
import { submitCoupon } from "../../redux/orderSlice"
import useForm from './../useForm'
import { removeCoupon } from "../../redux/cartSlice"


	export default function useCoupon() {
        const dispatch = useDispatch()

	    const { 
            // data,
            loading,
            error,
            validationErrors,
        } = useSelector((state) => state.order.coupon)

        const { 
            coupon,
            totalPrice
        } = useSelector((state) => state.cart)

        const {
	        formData,
	        errors,
	        handleChange,
	        clearForm,
	        setErrors,
            setFormData,
	    } = useForm ({ 
	    	code: '',
            cart_sub_total: totalPrice || '',
	    })

        useEffect(() => {
	        if (totalPrice) {
	            setFormData({
                    code: coupon?.code ? coupon?.code : "",
                    cart_sub_total: totalPrice || '',
	            })
	        }
	    }, [totalPrice, setFormData, coupon])

        // Handle server validation errors
	    useEffect(() => {
	        if (validationErrors) {
	            setErrors(validationErrors)
	        }
	    }, [validationErrors, setErrors])

	    // Handle general submission errors
	    useEffect(() => {
	        if (error) {
	            toast.error(error.message || 'An error occurred during submission')
	        }
	    }, [error])
	    
        const handleSubmit = async (e) => {
	        e.preventDefault()
	        try {
	            const res = await dispatch(submitCoupon(formData)).unwrap()         
	            toast.success(res.message)
	        } catch (err) {
	            console.log("Coupon Form: ", err)
	        }
	    }

        const handleRemoveCoupon = () => {
            dispatch(removeCoupon())
            clearForm()
            toast.success("Coupn successfully removed.")
        }

	    // console.log(loadingItems)

	    return {
            isApplied: Object.keys(coupon).length > 0,
	        isLoadingProfile: loading,
            handleRemoveCoupon,

            formData,
            errors,
            handleChange,
            handleSubmitCouponFom: handleSubmit,
	    }
	}