import React from 'react'

export default function UserProfile() {
    return (
        <>
             <div className="row mt-4">
        
                {/* Left Column: Form Fields */}
                <div className="col-md-8">
                <form>
                    <div className="mb-3">
                    <label htmlFor="firstName" className="form-label">First Name</label>
                    <input type="text" className="form-control" id="firstName" placeholder="Enter your first name" />
                    </div>
                    <div className="mb-3">
                    <label htmlFor="lastName" className="form-label">Last Name</label>
                    <input type="text" className="form-control" id="lastName" placeholder="Enter your last name" />
                    </div>
                    <div className="mb-3">
                    <label htmlFor="email" className="form-label">Email</label>
                    <input type="email" className="form-control" id="email" placeholder="example@mail.com" />
                    </div>
                    <div className="mb-3">
                    <label htmlFor="password" className="form-label">Password</label>
                    <input type="password" className="form-control" id="password" placeholder="Enter your password" />
                    </div>
                    <div className="mb-3">
                    <label htmlFor="confirmPassword" className="form-label">Confirm Password</label>
                    <input type="password" className="form-control" id="confirmPassword" placeholder="Re-enter your password" />
                    </div>
                    <button type="submit" className="btn btn-primary">Save</button>
                </form>
                </div>

                {/* Right Column: Avatar and File Upload */}
                <div className="col-md-4 d-flex flex-column align-items-center">
                <img
                    src="https://via.placeholder.com/150"
                    alt="User Avatar"
                    className="rounded-circle mb-3"
                    style={{ width: "150px", height: "150px", objectFit: "cover" }}
                />
                <div className="mb-3 w-100">
                    <label htmlFor="avatarUpload" className="form-label">Upload Avatar</label>
                    <input className="form-control" type="file" id="avatarUpload" />
                </div>
                </div>

            </div>
        </>
    )
}
