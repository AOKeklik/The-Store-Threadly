import { createContext, useContext, useEffect, useState } from 'react'
import axiosClient from '../config'
import Loader from '../components/layouts/Loader'

const SettingsContext = createContext({});

/* 
    categories: [
        {id: 4, name: 'T-Shirt', slug: 't-shirt', parent_id: 1, full_name: 'Product > T-Shirt'}
        {id: 14, name: 'Polo Shirts', slug: 'polo-shirts', parent_id: 1, full_name: 'Product > Polo Shirts'}
        {id: 15, name: 'Sweatshirts', slug: 'sweatshirts', parent_id: 1, full_name: 'Product > Sweatshirts'}
    ]

*/
export const SettingsProvider = ({ children }) => {
    const [settings, setSettings] = useState(null)
    const [productCategories, setProductCategories] = useState([])
    const [blogCategories, setBlogCategories] = useState([])
    const [colors, setColors] = useState([])
    const [sizes, setSizes] = useState([])

    useEffect(() => {
        const fetchSettings = async () => {
            try {
                await new Promise(resolve => setTimeout(resolve, 1000));
                const res = await axiosClient.get("/setting");
                setSettings(res.data.data)
                setProductCategories(res.data.product_categories)
                setBlogCategories(res.data.blog_categories)
                setColors(res.data.colors)
                setSizes(res.data.sizes)
            } catch (error) {
                console.error("Settings load failed:", error);
                setSettings({})
                setColors([])
                setSizes([])
            }
        };

        fetchSettings()
    }, [])

    if (settings === null) return <Loader />

    return (
        <SettingsContext.Provider value={{ 
            settings,
            productCategories,
            blogCategories,
            colors,
            sizes
        }}>
            {children}
        </SettingsContext.Provider>
    )
}

export const useSettings = () => {
    const context = useContext(SettingsContext)
    if (context === undefined) {
        throw new Error('useSettings must be used within a SettingsProvider')
    }
    return context
}
