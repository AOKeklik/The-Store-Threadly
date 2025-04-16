import { BrowserRouter, Routes, Route} from 'react-router-dom'


import Header from './components/layouts/Header'
import Footer from './components/layouts/Footer'
import PageNotFound from './pages/404/PageNotFound'
import Home from './pages/Home'
import BackToTop from './components/buttons/BackToTop'
import ProductPage from './pages/ProductPage/ProductPage'
import ProductSinglePage from './pages/ProductSinglePage/ProductSinglePage'

function App() {
    return  <BrowserRouter>
        <Header/>
        <BackToTop />
        <Routes>
            <Route path="/" element={<Home/>} />
            <Route path="/products" element={<ProductPage />} />
            <Route path="/product/:slug" element={<ProductSinglePage />} />
            <Route path="*" element={<PageNotFound/>} />
        </Routes>
        <Footer />
    </BrowserRouter>
}

export default App
