import React from 'react'
import { Link } from 'react-router-dom'

import { useSettings } from '../../context/settingContext'
import ButtonSubmitForm from '../../buttons/ButtonSubmitForm'

import useFormSignup from '../../hooks/auth/useFormSignup'

export default function SignupPage () {
    const {settings} = useSettings()

    const {
        formData,
        loading,
        errors,
        handleChange,
        handleSubmit
    } = useFormSignup()


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
            <Link to="/" className="text-center mb-5">
                <img src={settings.site_logo_url} alt="Logo" className="w-25" />
            </Link>
            
            {/* HEADER */}
            <h4 className="text-center text-danger mb-4">Register</h4>
    
            {/* FORM */}
            <form onSubmit={handleSubmit}>
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
                    <ButtonSubmitForm loading={loading} text="Register" />
                </div>
            </form>
    
            {/* LINK REGISTER */}
            <p className="text-center    mt-3 text-muted">
                Already have an account? <Link to="/signin" className="text-danger text-decoration-none">Login</Link>
                <br />
                <Link to="/reset" className='text-decoration-none text-danger'>Forget Password?</Link>
            </p>
        </div>
        </div>
    </div>
  
  
}
