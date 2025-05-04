import { useEffect } from 'react'
import useForm from '../useForm'
import { useDispatch, useSelector } from 'react-redux'
import { storeContact } from '../../redux/formSlice'
import { toast } from 'react-toastify'

const useFormContact = () => {
    const dispatch = useDispatch()
    const {
        loading, 
        error,
        validationErrors,
    } = useSelector(state => state.form.contactForm)
    
    const {
        formData,
        errors,
        handleChange,
        clearForm,
        setErrors
    } = useForm(
        { 
            name: '',
            email: '',
            subject: '',
            message: '',
        }
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
        
        try {
            const res = await dispatch(storeContact(formData)).unwrap()
            toast.success(res.message)
            clearForm()
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