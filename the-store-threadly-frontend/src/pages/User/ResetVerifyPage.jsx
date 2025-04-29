import React from 'react'
import { useSettings } from '../../context/settingContext'
import ButtonSubmitForm from '../../buttons/ButtonSubmitForm'
import useFormResetVerify from '../../hooks/useFormResetVerify'

export default function ResetVerifyPage() {
    const {settings} = useSettings()
    const {
        loading,
        formData,
        errors,
        handleChange,
        handleSubmit
    } = useFormResetVerify ()

    return <div className="container min-vh-100 d-flex align-items-center justify-content-center bg-light">
        <div className="w-100" style={{ maxWidth: '400px' }}>

        <div className="card shadow p-4">
            {/* LOGO */}
            <Link to="/" className="text-center mb-5">
                <img src={settings.site_logo_url} alt="Logo" className="w-25" />
            </Link>
            
            {/* HEADER */}
            <h4 className="text-center text-danger mb-4">Reset</h4>

            {/* FORM */}
            <form onSubmit={handleSubmit}>
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
                        id="password_confirmation" placeholder="Confirm Password" 
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
                    <ButtonSubmitForm loading={loading} text="Login" />
                </div>
            </form>
        </div>
        </div>
    </div>
}
