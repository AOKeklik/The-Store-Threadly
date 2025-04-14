import { BrowserRouter, Routes, Route} from 'react-router-dom'


import Header from './components/layouts/Header'
import PageNotFound from './components/404/PageNotFound'
import Home from './components/Home'
import BackToTop from './components/buttons/BackToTop'

function App() {
    return  <BrowserRouter>
        <Header/>
        <BackToTop />
        <Routes>
            <Route path="/" element={<Home/>} />
            <Route path="*" element={<PageNotFound/>} />
        </Routes>
    </BrowserRouter>
}

export default App
