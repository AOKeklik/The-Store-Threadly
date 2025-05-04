import React from 'react'
import Loader from './Loader'
import { Navigate, Outlet } from 'react-router-dom'
import { useAuth } from '../../hooks/auth/useAuth'

export default function LayoutProtected() {
    const { authChecked, isLoading, isAuthenticated } = useAuth()

    if (!authChecked || isLoading) {
        return <Loader />
    }

    if (!isAuthenticated) {
        return <Navigate to="/signin" replace />
    }

    return <Outlet />
}
