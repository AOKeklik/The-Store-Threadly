import axios from "axios"

export const URL_BASE = import.meta.env.VITE_URL_FRONTEND_BASE
export const URL_PRODUCT = URL_BASE + import.meta.env.VITE_PATH_PRODUCT
export const URL_BLOG = URL_BASE + import.meta.env.VITE_PATH_BLOG

export const URL_API = import.meta.env.VITE_URL_BACKEND_BASE + import.meta.env.VITE_PATH_API
export const URL_API_PRODUCT = URL_API + import.meta.env.VITE_PATH_PRODCT
export const URL_API_BLOG = URL_API + import.meta.env.VITE_PATH_BLOG


const axiosClient = axios.create({
    baseURL: URL_API,
    headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
    },
})



const axiosProtected = axios.create({
    baseURL: URL_API,
    headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
    },
})
axiosProtected.interceptors.request.use(config => {
    let authData = {};

    if (typeof window !== 'undefined') {
        try {
            authData = JSON.parse(localStorage.getItem('user') || '{}');
        } catch (e) {
            console.error('Error parsing localStorage user data:', e);
        }
    }

    if (authData?.token && authData?.tokenType) {
        config.headers.Authorization = `${authData.tokenType} ${authData.token}`;
    }

    return config
})



export {axiosProtected}  
export default axiosClient