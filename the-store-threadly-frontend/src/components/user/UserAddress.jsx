import React from 'react'
import useAddress from '../../hooks/profile/useAddress'

export default function UserAddress ({profile = {}}) {

    const {
        loading,
        handleSubmit,

        formData,
        handleChange,
        errors,
    } = useAddress (profile)
    
    return (
        <form onSubmit={handleSubmit}>
            <div className="mb-4">
                <input
                    name="phone"
                    value={formData.phone || ''}
                    onChange={handleChange}
                    className={`form-control ${errors.phone ? "is-invalid" : ""}`}
                    type="text" id="phone" placeholder="Phone" 
                />
                {
                    errors.phone && (
                        <small className='text-danger'>
                            {Array.isArray(errors.phone) ? errors.phone[0] : errors.phone}
                        </small>
                    )
                }
            </div>
            <div className="mb-4">
                <input 
                    name="country"
                    value={profile.country || ''}
                    className="form-control"
                    type="text" id="country" placeholder="Country" readOnly disabled
                />
            </div>
            <div className="mb-4">
                <input
                    name="state"
                    value={formData.state || ''}
                    onChange={handleChange}
                    className={`form-control ${errors.state ? "is-invalid" : ""}`}
                    type="text" id="state" placeholder="State" 
                />
                {
                    errors.state && (
                        <small className='text-danger'>
                            {Array.isArray(errors.state) ? errors.state[0] : errors.state}
                        </small>
                    )
                }
            </div>
            <div className="mb-4">
                <input
                    name="city"
                    value={formData.city || ''}
                    onChange={handleChange}
                    className={`form-control ${errors.city ? "is-invalid" : ""}`}
                    type="text" id="city" placeholder="City" 
                />
                {
                    errors.city && (
                        <small className='text-danger'>
                            {Array.isArray(errors.city) ? errors.city[0] : errors.city}
                        </small>
                    )
                }
            </div>
            <div className="mb-4">
                <input
                    name="zip"
                    value={formData.zip || ''}
                    onChange={handleChange}
                    className={`form-control ${errors.zip ? "is-invalid" : ""}`}
                    type="text" id="zip" placeholder="Zip" 
                />
                {
                    errors.zip && (
                        <small className='text-danger'>
                            {Array.isArray(errors.zip) ? errors.zip[0] : errors.zip}
                        </small>
                    )
                }
            </div>
            <div className="mb-4">
                <input
                    name="address"
                    value={formData.address || ''}
                    onChange={handleChange}
                    className={`form-control ${errors.address ? "is-invalid" : ""}`}
                    type="text" id="address" placeholder="Address" 
                />
                {
                    errors.address && (
                        <small className='text-danger'>
                            {Array.isArray(errors.address) ? errors.address[0] : errors.address}
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
