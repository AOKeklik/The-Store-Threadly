import { useState } from 'react'

const useForm = (initialValues = {}) => {
    const [formData, setFormData] = useState(initialValues)
    const [errors, setErrors] = useState({})

    const handleChange = (e) => {
        const { name, value } = e.target
        setFormData(prev => ({ ...prev, [name]: value }))
        
        // Clear error when user types
        if (errors[name]) {
            setErrors(prev => ({ ...prev, [name]: '' }))
        }
    }

    const clearForm = () => {
        setFormData(initialValues)
        setErrors({})
    }

    return {
        formData,
        errors,
        handleChange,
        clearForm,
        setErrors // For server-side validation
    }
}

export default useForm