import { Outlet } from "react-router-dom"

import Header from "./Header"
import Footer from "./Footer"

import BackToTop from "../../buttons/BackToTop"

export default function LayoutMain() {
    return (
        <>
            <Header />
            <BackToTop />
            <Outlet />
            <Footer />
        </>
    );
}
