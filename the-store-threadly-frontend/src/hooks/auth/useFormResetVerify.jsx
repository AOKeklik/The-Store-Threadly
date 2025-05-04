import React, { useEffect } from 'react'
import useForm from '../useForm'
import { useDispatch, useSelector } from 'react-redux'
import { toast } from 'react-toastify'
import { resetVerifySubmit } from '../../redux/authSlice'
import { useNavigate } from 'react-router-dom'

export default function useFormResetVerify() {
    const dispatch = useDispatch()

    const navigate = useNavigate()
    
    const queryParams = new URLSearchParams(location.search)
	const email = queryParams.get('email')
	const token = queryParams.get('token')

    const {
        validationErrors,
        error,
        loading,
    } = useSelector(state => state.auth.resetVerify)

    const {
        formData,
        errors,
        handleChange,
        clearForm,
        setErrors 
    } = useForm({
        email,
        token,
        password: "",
        password_confirmation: "",
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
            const res = await dispatch(resetVerifySubmit(formData)).unwrap()
            toast.success(res.message)
            clearForm()
            navigate("/signin")
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
