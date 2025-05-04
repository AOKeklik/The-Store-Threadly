import React from 'react'
import useProfileForm from '../../hooks/profile/useProfileForm'

export default function UserProfile({profile}) {
    const { 
        isUpdatingProfile,
        handleSubmitProfileForm,

        formData,
        handleChange,
        errors,
    } = useProfileForm(profile)
    
    return (
        <div>
             <form onSubmit={handleSubmitProfileForm} >
                <div className="mb-4 d-flex flex-column align-items-center">
                    <img
                        src={
                            formData.image instanceof File
                                ? URL.createObjectURL(formData.image)
                                : profile.image
                        }
                        alt="User Avatar"
                        className="rounded-circle mb-3"
                        style={{ width: "150px", height: "150px", objectFit: "cover" }}
                    />
                    <label htmlFor="avatarUpload" className="form-label">Upload Avatar</label>
                    <input 
                        name="image"
                        onChange={handleChange}
                        className={`form-control ${errors.image ? "is-invalid" : ""}`}
                        type="file" id="avatarUpload" 
                    />
                    {
                        errors?.image && (
                            <small className='text-danger'>
                                {Array.isArray(errors.image) ? errors.image[0] : errors.image}
                            </small>
                        )
                    }
                </div>
                <div className="mb-4">
                    <input
                        name='name'
                        value={formData.name}
                        onChange={handleChange}
                        className={`form-control ${errors.name ? "is-invalid" : ""}`}
                        type="text" id="firstName" placeholder="Full Name" 
                    />
                    {
                        errors?.name && (
                            <small className='text-danger'>
                                {Array.isArray(errors.name) ? errors.name[0] : errors.name}
                            </small>
                        )
                    }
                </div>
                <div className="mb-4">
                    <input 
                        name='email'
                        value={formData.email}
                        onChange={handleChange}
                        className={`form-control ${errors.email ? "is-invalid" : ""}`}
                        type="text"  id="email" placeholder="example@mail.com" 
                    />
                    {
                        errors.email && (
                            <small className='text-danger'>
                            {Array.isArray(errors.email) ? errors.email[0] : errors.email}
                            </small>
                        )
                    }
                </div>
                <button 
                    disabled={isUpdatingProfile}
                    className="btn btn-outline-danger d-flex align-items-center gap-2"
                    type="submit" 
                >
                    {
                        isUpdatingProfile && (
                            <span className="spinner-grow spinner-grow-sm bg-danger" aria-hidden="true"></span>
                        )
                    }
                    Save
                </button>
            </form>
        </div>
    )
}
