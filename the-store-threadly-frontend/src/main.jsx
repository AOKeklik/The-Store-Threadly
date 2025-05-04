import { StrictMode } from 'react'
import { createRoot } from 'react-dom/client'

import 'bootstrap/dist/css/bootstrap.min.css'
import 'bootstrap/dist/js/bootstrap.min.js'
import 'bootstrap-icons/font/bootstrap-icons.css'
import 'react-toastify/dist/ReactToastify.css'

import './index.css'
import App from './App.jsx'

import { ToastContainer } from 'react-toastify'
import { StoreProvider } from './redux/store'

import { SettingsProvider } from './context/settingContext'

createRoot(document.getElementById('root')).render(
    <StrictMode>
        <ToastContainer position='top-right'/>
        <SettingsProvider>
            <StoreProvider>
                <App />
            </StoreProvider>
        </SettingsProvider>
    </StrictMode>,
)