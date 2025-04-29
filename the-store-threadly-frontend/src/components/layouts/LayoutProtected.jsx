import React from 'react';
import Loader from './Loader';
import { useAuth } from '../../hooks/useAuth';
import { Navigate, Outlet } from 'react-router-dom';

export default function LayoutProtected() {
    const { authChecked, isLoading, isAuthenticated } = useAuth()

    if (!authChecked || isLoading) {
        return <Loader />;
    }

    if (!isAuthenticated) {
        return <Navigate to="/signin" replace />;
    }

    return <Outlet />;
}
