import { useState } from 'react'

const useForm = (initialValues = {}, validationRules = {}) => {
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

    const resetForm = () => {
        setFormData(initialValues)
        setErrors({})
    }

    const validate = () => {
        const newErrors = {}
        
        Object.entries(validationRules).forEach(([field, validateFn]) => {
            const error = validateFn(formData[field], formData)
            if (error) newErrors[field] = error
        })

        setErrors(newErrors)
        return Object.keys(newErrors).length === 0
    }

    return {
        formData,
        errors,
        handleChange,
        validate,
        resetForm,
        setErrors // For server-side validation
    }
}

export default useForm