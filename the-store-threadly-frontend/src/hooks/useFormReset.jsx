import React, { useEffect } from 'react'
import useForm from './useForm'
import { useDispatch, useSelector } from 'react-redux'
import { toast } from 'react-toastify'
import { resetSubmit } from '../redux/authSlice'

export default function useFormReset() {
    const dispatch = useDispatch()
    const {
        validationErrors,
        error,
        loading,
    } = useSelector(state => state.auth.reset)

    const {
        formData,
        errors,
        handleChange,
        clearForm,
        setErrors 
    } = useForm({
        email: ""
    })

    useEffect(() => {
        if(validationErrors) {
            setErrors(validationErrors)
        }
    }, [validationErrors, setErrors])

    useEffect(() => {
        if(error) {
            toast.error(error.message || "An error occurred during submission!")
        }
    }, [error])


    const handleSubmit = async (e) => {
        e.preventDefault()
        try{
            const res = await dispatch(resetSubmit(formData)).unwrap()
            toast.success(res.message)
            clearForm()
        }catch(err){
            console.log("Reset Form: ", err)
        }
    }
    return {
        loading,
        formData,
        errors,
        handleChange,
        handleSubmit,
    }
}
