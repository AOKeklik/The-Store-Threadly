import React from 'react'
import { useSettings } from '../../context/settingContext'
import ButtonSubmitForm from '../../buttons/ButtonSubmitForm'
import { Link } from 'react-router-dom'

import useFormReset from '../../hooks/auth/useFormReset'

export default function ResetPage() {
    const {settings} = useSettings()
    const {
        loading,
        formData,
        errors,
        handleChange,
        handleSubmit
    } = useFormReset ()

    return <div className="container min-vh-100 d-flex align-items-center justify-content-center bg-light">
        <div className="w-100" style={{ maxWidth: '400px' }}>
        
        {/* GO BACK */}
        <div className="mb-5 text-start">
            <Link to="/signin" className="btn btn-outline-danger btn-sm">
                ← Back to Signin
            </Link>
        </div>

        <div className="card shadow p-4">
            {/* LOGO */}
            <Link to="/" className="text-center mb-5">
                <img src={settings.site_logo_url} alt="Logo" className="w-25" />
            </Link>
            
            {/* HEADER */}
            <h4 className="text-center text-danger mb-4">Reset</h4>

            {/* FORM */}
            <form onSubmit={handleSubmit}>
                <div className="mb-5">
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
                <div className="d-grid">
                    <ButtonSubmitForm loading={loading} text="Login" />
                </div>
            </form>
        </div>
        </div>
    </div>
}
