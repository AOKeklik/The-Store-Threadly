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
axiosProtected.interceptors.request.use(async config => {

    await new Promise(resolve => setTimeout(resolve, 1000));

    if (typeof window !== 'undefined') {
        try {
            const authData = JSON.parse(localStorage.getItem('user') || '{}');
            if (authData?.token && authData?.tokenType) {
                config.headers.Authorization = `${authData.tokenType} ${authData.token}`;
            }
        } catch (e) {
            console.error('Error parsing localStorage user data:', e);
        }
    }

    return config
})



export {axiosProtected}  
export default axiosClient