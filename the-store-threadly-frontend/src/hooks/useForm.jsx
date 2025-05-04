import { useState } from 'react'

const useForm = (initialValues = {}) => {
    const [formData, setFormData] = useState(initialValues)
    const [errors, setErrors] = useState({})

    const handleChange = (e) => {
        const { name, type, files, value } = e.target        
        const newValue = type === 'file' ? files[0] : value

        setFormData(prev => ({ ...prev, [name]: newValue }))
        
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
        setErrors, // For server-side validation
        setFormData, // For server-side set form values
    }
}

export default useForm