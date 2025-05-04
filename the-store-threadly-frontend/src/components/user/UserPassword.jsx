import React from 'react'
import usePassword from '../../hooks/profile/usePassword'

export default function UserPassword() {

    const {
        loading,
        handleSubmit,

        formData,
        handleChange,
        errors,
    } = usePassword ()
    
    return (
        <form onSubmit={handleSubmit}>
            <div className="mb-4">
                <input
                    name="password_existing"
                    value={formData.password_existing}
                    onChange={handleChange}
                    className={`form-control ${errors.password_existing ? "is-invalid" : ""}`}
                    type="text" id="password_existing" placeholder="Current Password" 
                />
                {
                errors.password_existing && (
                    <small className='text-danger'>
                        {Array.isArray(errors.password_existing) ? errors.password_existing[0] : errors.password_existing}
                    </small>
                )
            }
            </div>
            <div className="mb-4">
                <input 
                    name="password"
                    value={formData.password}
                    onChange={handleChange}
                    className={`form-control ${errors.password ? "is-invalid" : ""}`}
                    type="text" id="password" placeholder="Password" 
                />
                {
                errors.password && (
                    <small className='text-danger'>
                        {Array.isArray(errors.password) ? errors.password[0] : errors.password}
                    </small>
                )
            }
            </div>
            <div className="mb-4">
                <input
                    name="password_confirmation"
                    value={formData.password_confirmation}
                    onChange={handleChange}
                    className={`form-control ${errors.password_confirmation ? "is-invalid" : ""}`}
                    type="text" id="password_confirmation" placeholder="Confirm Password" 
                />
                {
                errors.password_confirmation && (
                    <small className='text-danger'>
                        {Array.isArray(errors.password_confirmation) ? errors.password_confirmation[0] : errors.password_confirmation}
                    </small>
                )
            }
            </div>
            <button 
                disabled={loading}
                type="submit" className="btn btn-outline-danger d-flex align-items-center gap-2"
            >
                {
                    loading && (
                        <span className="spinner-grow spinner-grow-sm bg-danger" aria-hidden="true"></span>
                    )
                }
                Save
            </button>
        </form>
    )
}
