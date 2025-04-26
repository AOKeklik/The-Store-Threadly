import React from 'react'
import { useSettings } from '../../context/settingContext'
import { Link } from 'react-router-dom'

export default function SigninPage () {
    const {settings} = useSettings()

    // console.log(formData,errors)

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
            <form>
                <div className="mb-3">
                    <input 
                        type="text"
                        name="email"
                        className="form-control" 
                        id="email" placeholder="Enter your email" 
                    />
                </div>
                <div className="mb-5">
                    <input type="password" className="form-control" id="password" placeholder="Enter your password" />
                </div>
                <div className="d-grid">
                    <button type="submit" className="btn btn-danger">Login</button>
                </div>
            </form>
    
            {/* LINK REGISTER */}
            <p className="text-center mt-3 text-muted">
                Don't have an account? <Link to="/signup" className="text-danger">Register</Link>
            </p>
        </div>
        </div>
    </div>
  
  
}
