import { Navigate, Outlet } from "react-router-dom"
import Loader from "./Loader"
import { useAuth } from "../../hooks/auth/useAuth"

export default function LayoutGuest() {
    const { isAuthenticated, authChecked, isLoading } = useAuth();

    if (!authChecked || isLoading) {
        return <Loader />;
    }

    if (isAuthenticated) {
        return <Navigate to="/dashboard" replace />;
    }

    return (
        <main className="min-vh-100 d-flex align-items-center justify-content-center bg-light">
            <Outlet />
        </main>
    );
}
