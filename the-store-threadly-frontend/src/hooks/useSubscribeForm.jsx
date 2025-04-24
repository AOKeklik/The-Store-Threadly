import { useEffect, useState } from 'react'
import useForm from './useForm';
import { useDispatch, useSelector } from 'react-redux';
import { storeSubscriber } from '../redux/formSlice';
import { toast } from 'react-toastify';

const useSubscriberForm = () => {
    const dispatch = useDispatch();
    const {
        data,
        loading, 
        validationErrors 
    } = useSelector(state => state.form.subscribeForm);

    const validationRules = {
        email: (value) => {
            if (!value) return 'Email is required';
            if (!/\S+@\S+\.\S+/.test(value)) return 'Valid email is required';
            return null;
        }
    }
    
    const {
        formData,
        errors,
        handleChange,
        validate,
        resetForm,
        setErrors
    } = useForm({ email: '' }, validationRules)

     // Handle server validation errors
     useEffect(() => {
        if (validationErrors) {
            setErrors(validationErrors)
        }
    }, [validationErrors, setErrors])


    const handleSubmit = async (e) => {
        e.preventDefault();
        if (!validate()) return;
        
        try {
            const res = await dispatch(storeSubscriber(formData)).unwrap()
            toast.success(res.message)
            resetForm()
            // Show success message if needed
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


export default useSubscriberForm