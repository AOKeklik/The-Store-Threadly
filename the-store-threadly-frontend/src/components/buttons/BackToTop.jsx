import { useEffect, useState } from 'react'
import "./BackToTop.css"

export default function BackToTop() {
    const [isVisible, setIsVisible] = useState(false);

    const toggleVisibility = () => {
        setIsVisible(window.scrollY > 300)
    }

    const scrollToTop = () => {
        window.scrollTo({ top: 0, behavior: 'smooth' })
    }

    useEffect(() => {
        window.addEventListener('scroll', toggleVisibility)
        return () => window.removeEventListener('scroll', toggleVisibility)
    }, [])

    return (
        <button
            className={`btn btn-danger back-to-top ${isVisible ? 'show' : ''}`}
            onClick={scrollToTop}
        >
            <i className="bi bi-arrow-up"></i>
        </button>
    )
}
