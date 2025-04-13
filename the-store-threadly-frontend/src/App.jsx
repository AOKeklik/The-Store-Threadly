import { BrowserRouter, Routes, Route} from 'react-router-dom'


import Header from './components/layouts/Header'
import PageNotFound from './components/404/PageNotFound'
import Home from './components/Home'

function App() {
    return  <BrowserRouter>
        <Header/>
        <div id='page' className='container-fluid'>
            <Routes>
                <Route path="/" element={<Home/>} />
                <Route path="*" element={<PageNotFound/>} />
            </Routes>
        </div>
    </BrowserRouter>
}

export default App
