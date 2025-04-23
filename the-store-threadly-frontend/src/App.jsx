import { BrowserRouter, Routes, Route} from 'react-router-dom'


import Header from './components/layouts/Header'
import Footer from './components/layouts/Footer'
import PageNotFound from './pages/404/PageNotFound'
import Home from './pages/Home'
import BackToTop from './buttons/BackToTop'

import ProductPage from './pages/ProductPage/ProductPage'
import ProductSinglePage from './pages/ProductSinglePage/ProductSinglePage'
import CartPage from './pages/CartPage/CartPage'
import BlogPage from './pages/BlogPage/BlogPage'

import { SettingsProvider } from './context/settingContext'
import { Suspense } from 'react'
import Loader from './components/layouts/Loader'
import { WishlistProvider } from './context/wishlistContext'
import BlogSinglePage from './pages/BlogSinglePage/BlogSinglePage'

function App() {
    return  <BrowserRouter>
        <SettingsProvider>
            <WishlistProvider>
                <Suspense fallback={<Loader />}>
                    <Header/>
                    <BackToTop />
                    <Routes>
                        <Route path="/" element={<Home/>} />
                        <Route path="/products" element={<ProductPage />} />
                        <Route path="/product/:slug" element={<ProductSinglePage />} />
                        <Route path="/blogs" element={<BlogPage />} />
                        <Route path="/blog/:slug" element={<BlogSinglePage />} />
                        <Route path="/cart" element={<CartPage />} />
                        <Route path="*" element={<PageNotFound/>} />
                    </Routes>
                    <Footer />
                </Suspense>
            </WishlistProvider>
        </SettingsProvider>
    </BrowserRouter>
}

export default App
