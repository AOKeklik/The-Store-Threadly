import { Outlet } from "react-router-dom";

export default function LayoutAuth() {
    return (
        <main className="min-vh-100 d-flex align-items-center justify-content-center bg-light">
            <Outlet />
        </main>
    );
}
