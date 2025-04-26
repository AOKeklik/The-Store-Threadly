import React, { useEffect } from 'react'
import { useSettings } from '../../context/settingContext'
import useForm from '../../hooks/useForm'
import { Link, useNavigate } from 'react-router-dom'
import { useDispatch, useSelector } from 'react-redux'
import { signupSubmit } from '../../redux/authSlice'
import { toast } from 'react-toastify'

export default function SignupPage () {
    const {settings} = useSettings()
    
    
/* ///////// signup ///////// */
    const navigate = useNavigate()
    const dispatch = useDispatch()
    const {
        loading, 
        error,
        validationErrors,
    } = useSelector(state => state.auth.signup)

    const initialValues = {
        name: "",
        email: "",
        password: "",
        password_confirmation: "",
    }

    const {
        validate,
        handleChange,
        formData,
        errors,
        setErrors,
        resetForm
    } = useForm(
        initialValues,
    )

    useEffect(() => {
        if (validationErrors) {
            setErrors(validationErrors)
        }
    }, [validationErrors, setErrors])

    useEffect(() => {
        if (error) {
            toast.error(error.message || 'An error occurred during submission')
        }
    }, [error])

    const handlerSubmit = async (e) => {
        e.preventDefault ()

        if(!validate()) return

        try {
            const res = await dispatch(signupSubmit(formData)).unwrap()
            toast.success(res.message)
            resetForm ()
            navigate('/signin')
        }catch(err){
            console.error('Submission error:', err)
        }
    }
/* ///////// signup ///////// */


    return <div className="container min-vh-100 d-flex align-items-center justify-content-center bg-light">
        <div className="w-100" style={{ maxWidth: '400px' }}>
        
        {/* GO BACK */}
        <div className="mb-5 text-start">
            <a href="/" className="btn btn-outline-danger btn-sm">
                ← Back to site
            </a>
        </div>
    
        <div className="card shadow p-4">
            {/* LOGO */}
            <div className="text-center mb-5">
                <img src={settings.site_logo_url} alt="Logo" className="w-25" />
            </div>
            
            {/* HEADER */}
            <h4 className="text-center text-danger mb-4">Register</h4>
    
            {/* FORM */}
            <form onSubmit={handlerSubmit}>
                <div className="mb-3">
                    <input 
                        type="text"
                        name="name"
                        value={formData.name}
                        onChange={handleChange}
                        className={`form-control ${errors.name ? "is-invalid" : ""}`}
                        id="name" placeholder="Full name" 
                    />
                    {
                        errors.name && (
                            <small className='text-danger'>
                                {Array.isArray(errors.name) ? errors.name[0] : errors.name}
                            </small>
                        )
                    }
                </div>
                <div className="mb-3">
                    <input 
                        type="text"
                        name="email"
                        value={formData.email}
                        onChange={handleChange}
                        className={`form-control ${errors.email ? "is-invalid" : ""}`}
                        id="email" placeholder="Email" 
                    />
                    {
                        errors.email && (
                            <small className='text-danger'>
                                {Array.isArray(errors.email) ? errors.email[0] : errors.email}
                            </small>
                        )
                    }
                </div>
                <div className="mb-3">
                    <input 
                        type="text" 
                        name="password"
                        value={formData.password}
                        onChange={handleChange}
                        className={`form-control ${errors.password ? "is-invalid" : ""}`}
                        id="password" placeholder="Password" 
                    />
                    {
                        errors.password && (
                            <small className='text-danger'>
                                {Array.isArray(errors.password) ? errors.password[0] : errors.password}
                            </small>
                        )
                    }
                </div>
                <div className="mb-5">
                    <input 
                        type="text" 
                        name="password_confirmation"
                        value={formData.password_confirmation}
                        onChange={handleChange}
                        className={`form-control ${errors.password_confirmation ? "is-invalid" : ""}`}
                        id="password" placeholder="Confirm password" 
                    />
                    {
                        errors.password_confirmation && (
                            <small className='text-danger'>
                                {Array.isArray(errors.password_confirmation) ? errors.password_confirmation[0] : errors.password_confirmation}
                            </small>
                        )
                    }
                </div>
                <div className="d-grid">
                    <button 
                        disabled={loading}
                        type="submit" className="btn btn-danger"
                    >
                        {loading ? "Submitting..." : "Signup"}
                    </button>
                </div>
            </form>
    
            {/* LINK REGISTER */}
            <p className="text-center mt-3 text-muted">
                Already have an account? <Link to="/signin" className="text-danger">Login</Link>
            </p>
        </div>
        </div>
    </div>
  
  
}
