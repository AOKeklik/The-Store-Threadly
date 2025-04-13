import { useState, useEffect } from "react"

const useFetch = (url) => {
    const [data, setData] = useState([])
    const [loading, setLoading] = useState(true)
    const [error, setError] = useState(null)

    useEffect(() => {
        const fetchData = async () => {
            try {
                setLoading(true)
                setError(null)

                await new Promise(resolve => setTimeout(resolve, 1000))
                const res = await fetch(url)

                if (!res.ok)
                    throw new Error(`HTTP error! Status: ${res.status}`)

                const result = await res.json()
                setData(result)
            } catch (err) {
                console.error("Fetch Error:", err)
                setError(err.message)
            } finally {
                setLoading(false)
            }
        };

        fetchData()
    }, [url])

    return [ data, loading, error ]
}

export default useFetch