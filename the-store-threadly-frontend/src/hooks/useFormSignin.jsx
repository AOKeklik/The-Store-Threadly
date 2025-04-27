import React, { useEffect } from 'react'
import { signinSubmit } from '../redux/authSlice'
import { useNavigate } from 'react-router-dom'
import { useDispatch, useSelector } from 'react-redux'
import { toast } from 'react-toastify'
import useForm from './useForm'

export default function useFormSignin() {
    const navigation = useNavigate()
    const dispatch = useDispatch()

    const {
        formData,
        errors,
        handleChange,
        clearForm,
        setErrors 
    } = useForm({
        email: "",
        password: ""
    })

    const {
        validationErrors,
        error,
        loading,
    } = useSelector(state => state.auth.signin)


    useEffect(() => {   
        if(validationErrors) {
            setErrors(validationErrors)
        }
    }, [validationErrors, setErrors])

    useEffect(() => {   
        if(error) {
            toast.error(error || 'An error occurred during submission')
        }
    }, [error])

    const handleSubmit = async (e) => {
        e.preventDefault()
        try {
            const res = await dispatch(signinSubmit(formData)).unwrap()
            toast.success(res.message)
            clearForm()
            navigation("/dashboard")
        } catch (err) {
            console.log("Signin Form: ", err)
        }
    }

    return {
        formData,
        loading,
        errors,
        handleSubmit,
        handleChange,
    }
}
