import { useState, useEffect } from 'react'

const useScrollFixedHeader = () => {
    const [fixedHeader, setFixedHeader] = useState(false)

    useEffect(() => {
    const handleScroll = () => {
        setFixedHeader(window.scrollY > 50)
    };

    window.addEventListener('scroll', handleScroll)

    return () => {
        window.removeEventListener('scroll', handleScroll)
    }
    }, [])

    return fixedHeader
}

export default useScrollFixedHeader