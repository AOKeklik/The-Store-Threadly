import { useSelector, useDispatch } from "react-redux"
import { useEffect } from "react"
import { toast } from "react-toastify"
import { updateAddress } from "../../redux/customerSlice"
import useForm from "../useForm"


export default function useAddress(profile) {
    const dispatch = useDispatch()
    
    const { 
        loading, 
        error, 
        validationErrors
    } = useSelector((state) => state.customer.address)

    const {
        formData,
        errors,
        handleChange,
        setErrors,
    } = useForm ({
        phone: profile.phone || '',
        country: profile.country || '',
        state: profile.state || '',
        city: profile.city || '',
        zip: profile.zip || '',
        address: profile.address || '',
    })

    useEffect(() => {
        if(validationErrors)
            setErrors(validationErrors?.errors)
    }, [validationErrors, setErrors])

    useEffect(() => {
        if(error) {
            toast.error(error.message || "An error occurred during submission!")
        }
    }, [error])

    const handleSubmit = async (e) => {
        e.preventDefault()
        try {
            const res = await dispatch(updateAddress(formData)).unwrap()
            toast.success(res.message)
        } catch (err) {
            console.log("Submit address form: ", err)
        }
    }


    // console.log(errors)

    return {
        loading,
        handleSubmit,

        formData,
        handleChange,
        errors,
    }
}