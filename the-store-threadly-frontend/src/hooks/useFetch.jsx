import { useState, useEffect } from "react"
import axiosClient from "../config"

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
                const res = await axiosClient.get(url)
                setData(res.data)
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