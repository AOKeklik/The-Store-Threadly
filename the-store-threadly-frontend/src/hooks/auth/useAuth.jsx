import { useEffect, useCallback } from 'react'
import { useSelector, useDispatch } from 'react-redux'
import { useNavigate, useLocation } from 'react-router-dom'
import { checkAuth, logout } from '../../redux/authSlice'

export const useAuth = () => {
    const dispatch = useDispatch()
    const navigate = useNavigate()
    const location = useLocation()
    
    const { 
        auth: { isAuthenticated, authChecked },
        user: { user, token },
        // signin: { loading: signinLoading },
        // signup: { loading: signupLoading },
        logout: { loading: logoutLoading }
    } = useSelector(state => state.auth)

    useEffect(() => {
        if (!authChecked) {
            dispatch(checkAuth())
        }
    }, [authChecked, dispatch])
    
    const handleLogout = useCallback(async () => {
        try {
            await dispatch(logout()).unwrap()
            navigate('/signin', { 
                state: { from: location },
                replace: true 
            })
        } catch (error) {
            console.error('Logout failed:', error)
        }
    }, [dispatch, navigate, location])
    

    return {
        // State
        user,
        token,
        isAuthenticated,
        authChecked,
        
        // Loading states
        isLoading: !authChecked,
        isLoggingOut: logoutLoading,
        
        // Methods
        logout: handleLogout,
    }
}
