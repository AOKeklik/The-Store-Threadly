import { useEffect } from 'react'
import useForm from './useForm'
import { useDispatch, useSelector } from 'react-redux'
import { storeContact } from '../redux/formSlice'
import { toast } from 'react-toastify'

const useFormContact = () => {
    const dispatch = useDispatch()
    const {
        loading, 
        error,
        validationErrors,
    } = useSelector(state => state.form.contactForm)

    const validationRules = {
        name: (value) => {
            if (!value) return 'Name is required'
            if (value.length < 3 || value.length > 21) return 'Minimum 3 maximum 21 characters!'
            return null
        },
        email: (value) => {
            if (!value) return 'Email is required'
            if (!/\S+@\S+\.\S+/.test(value)) return 'Valid email is required'
            return null
        },
        subject: (value) => {
            if (!value) return 'Subject is required'
            if (value.length < 11 || value.length > 51) return 'Minimum 3 maximum 51 characters!'
            return null
        },
        message: (value) => {
            if (!value) return 'Message is required'
            if (value.length < 9 || value.length > 999) return 'Minimum 9 maximum 999 characters!'
            return null
        }
    }
    
    const {
        formData,
        errors,
        handleChange,
        validate,
        resetForm,
        setErrors
    } = useForm(
        { 
            name: '',
            email: '',
            subject: '',
            message: '',
        }, 
        validationRules
    )

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
        if (!validate()) return
        
        try {
            const res = await dispatch(storeContact(formData)).unwrap()
            toast.success(res.message)
            resetForm()
            // Show success message if needed
        } catch (error) {
            // General errors are handled by Redux
            console.error('Submission error:', error)
        }
    }

    return {
        formData,
        loading,
        errors,
        handleChange,

        handleSubmit
    }
}


export default useFormContact