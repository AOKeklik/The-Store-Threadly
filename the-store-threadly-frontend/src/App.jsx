import { Suspense } from 'react'
import { BrowserRouter, Routes, Route} from 'react-router-dom'

import { SettingsProvider } from './context/settingContext'

import PageNotFound from './pages/404/PageNotFound'
import Home from './pages/Home'
import ProductPage from './pages/ProductPage/ProductPage'
import ProductSinglePage from './pages/ProductSinglePage/ProductSinglePage'
import CartPage from './pages/CartPage/CartPage'
import BlogPage from './pages/BlogPage/BlogPage'
import BlogSinglePage from './pages/BlogSinglePage/BlogSinglePage'
import ContactPage from './pages/ContactPage/ContactPage'
import WishlistPage from './pages/WishlistPage/WishlistPage'

import AboutPage from './pages/Page/AboutPage'
import TermsPage from './pages/Page/TermsPage'
import PrivacyPage from './pages/Page/PrivacyPage'
import CookiesPage from './pages/Page/CookiesPage'
import RefundsPage from './pages/Page/RefundsPage'

import SigninPage from './pages/User/SigninPage'
import SignupPage from './pages/User/SignupPage'
import ProfilePage from './pages/User/ProfilePage'
import DashboardPage from './pages/User/DashboardPage'

import LayoutMain from './components/layouts/LayoutMain'
import Loader from './components/layouts/Loader'
import LayoutAuth from './components/layouts/LayoutAuth'
import ResetPage from './pages/User/ResetPage'
import ForgetPage from './pages/User/ForgetPage'

function App() {
    return  <BrowserRouter>
        <SettingsProvider>
            <Suspense fallback={<Loader />}>
                <Routes>
                    <Route element={<LayoutMain />}>
                        <Route path="/" element={<Home/>} />
                        
                        <Route path="/about" element={<AboutPage />} />
                        <Route path="/terms" element={<TermsPage />} />
                        <Route path="/privacy" element={<PrivacyPage />} />
                        <Route path="/cookies" element={<CookiesPage />} />
                        <Route path="/refunds" element={<RefundsPage />} />
                        <Route path="/contact" element={<ContactPage />} />

                        <Route path="/products" element={<ProductPage />} />
                        <Route path="/product/:slug" element={<ProductSinglePage />} />

                        <Route path="/blogs" element={<BlogPage />} />
                        <Route path="/blog/:slug" element={<BlogSinglePage />} />

                        <Route path="/cart" element={<CartPage />} />

                        <Route path="/wishlist" element={<WishlistPage />} />

                        <Route path="/profile" element={<ProfilePage />} />
                        <Route path="/dashboard" element={<DashboardPage />} />
                    </Route>

                    <Route element={<LayoutAuth />}>
                        <Route path="/signin" element={<SigninPage />} />
                        <Route path="/signup" element={<SignupPage />} />
                        <Route path="/reset/:email/:token" element={<ResetPage />} />
                        <Route path="/forget" element={<ForgetPage />} />
                    </Route>                    

                    <Route path="*" element={<PageNotFound/>} />
                </Routes>
            </Suspense>
        </SettingsProvider>
    </BrowserRouter>
}

export default App
