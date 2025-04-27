import React from 'react'
import { Link } from 'react-router-dom'

import ButtonSubmitForm from '../../buttons/ButtonSubmitForm'

import { useSettings } from '../../context/settingContext'
import useFormSignin from '../../hooks/useFormSignin'

export default function SigninPage () {
    const {settings} = useSettings()
    const {
        formData,
        loading,
        errors,
        handleChange,
        handleSubmit,
    } = useFormSignin()


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
            <h4 className="text-center text-danger mb-4">Login</h4>
    
            {/* FORM */}
            <form onSubmit={handleSubmit}>
                <div className="mb-3">
                    <input 
                        type="text"
                        name="email"
                        value={formData.email}
                        onChange={handleChange}
                        className={`form-control ${errors.email ? "is-invalid" : ""}`}
                        id="email" placeholder="Enter your email" 
                    />
                    {
                        errors.email && (
                            <small className='text-danger'>
                                {Array.isArray(errors.email) ? errors.email[0] : errors.email}
                            </small>
                        )
                    }
                </div>
                <div className="mb-5">
                    <input 
                        type="text"
                        name="password"
                        value={formData.password}
                        onChange={handleChange} 
                        className={`form-control ${errors.password ? "is-invalid" : ""}`}
                        id="password" placeholder="Enter your password" 
                    />
                    {
                        errors.password && (
                            <small className='text-danger'>
                                {Array.isArray(errors.password) ? errors.password[0] : errors.password}
                            </small>
                        )
                    }
                </div>
                <div className="d-grid">
                    <ButtonSubmitForm loading={loading} text="Login" />
                </div>
            </form>
    
            {/* LINK REGISTER */}
            <p className="text-center mt-3 text-muted">
                Don't have an account? <Link to="/signup" className="text-danger text-decoration-none">Register</Link>
                <br />
                <Link to="/reset" className='text-decoration-none text-danger'>Forget Password?</Link>
            </p>
        </div>
        </div>
    </div>
  
  
}
