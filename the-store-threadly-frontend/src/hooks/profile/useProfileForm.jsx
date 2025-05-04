import { useSelector, useDispatch } from "react-redux"
import { useEffect } from "react"
import { toast } from "react-toastify"
import { updateProfile } from "../../redux/customerSlice"
import useForm from "../useForm"


export default function useProfileForm(profile) {
    const dispatch = useDispatch()
    
    const { 
        loading, 
        error, 
        validationErrors
    } = useSelector((state) => state.customer.profile.update)

    const {
        formData,
        errors,
        handleChange,
        setErrors,
    } = useForm ({
        name: profile?.name || '',
        email: profile?.email || '',
        image: null,
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
            const res = await dispatch(updateProfile(formData)).unwrap()
            toast.success(res.message)
        } catch (err) {
            console.log("Submit profil form: ", err)
        }
    }


    // console.log(errors)

    return {
        isUpdatingProfile: loading,
        handleSubmitProfileForm: handleSubmit,

        formData,
        handleChange,
        errors,
    }
}