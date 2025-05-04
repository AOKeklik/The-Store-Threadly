import { useSelector, useDispatch } from "react-redux"
import { useEffect } from "react"
import { toast } from "react-toastify"
import { updatePassword } from "../../redux/customerSlice"
import useForm from "../useForm"


export default function usePassword() {
    const dispatch = useDispatch()
    
    const { 
        loading, 
        error, 
        validationErrors
    } = useSelector((state) => state.customer.password)

    const {
        formData,
        errors,
        handleChange,
        setErrors,
        clearForm
    } = useForm ({
        password_existing: '',
        password: '',
        password_confirmation: '',
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
            const res = await dispatch(updatePassword(formData)).unwrap()
            toast.success(res.message)
            clearForm ()
        } catch (err) {
            console.log("Submit password form: ", err)
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