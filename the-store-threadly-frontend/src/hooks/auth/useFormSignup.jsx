import { useEffect } from 'react'
import useForm from '../useForm'
import { useDispatch, useSelector } from 'react-redux'
import { toast } from 'react-toastify'
import { signupSubmit } from '../../redux/authSlice'
import { useNavigate } from 'react-router-dom'

export default function useFormSignup() {
    const navigate = useNavigate()
    const dispatch = useDispatch();
    const {
        loading, 
        error,
        validationErrors 
    } = useSelector(state => state.auth.signup);

    const {
        formData,
        errors,
        handleChange,
        clearForm,
        setErrors
    } = useForm({ 
        name: "",
        email: "",
        password: "",
        password_confirmation: "",
    })

     // Handle server validation errors
     useEffect(() => {
        if (validationErrors) {
            setErrors(validationErrors)
        }
    }, [validationErrors, setErrors])

    // Handle general submission errors
    useEffect(() => {
        if (error) {
            toast.error(error.message || 'An error occurred during submission');
        }
    }, [error]);


    const handleSubmit = async (e) => {
        e.preventDefault()
        
        try {
            // Show success
            const res = await dispatch(signupSubmit(formData)).unwrap()
            await toast.success(res.message)
            await clearForm()
            navigate('/signin')
        } catch (error) {
            // General errors are handled by Redux
            console.error('Submission error:', error);
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
