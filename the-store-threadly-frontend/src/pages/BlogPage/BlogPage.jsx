import React from 'react'

import useBlog from '../../hooks/useBlog'
import { useSettings } from '../../context/settingContext'

import Baner from '../../components/layouts/Baner'
import Loader from '../../components/layouts/Loader'
import BlogPrimaryItem from '../../components/blog/BlogPrimaryItem'

export default function BlogPage() {
    const { blogCategories } = useSettings()
    const { 
        dataFilteredBlog,
        metaFilteredBlog,
        loadingFilteredBlog,

        selectedCategory, 
        handleCategorySelect, 
        resetFilters,

        setPage
    } = useBlog()

    return <>
        <Baner {...{
            title: "Our Blogs",
            breadcrumbs: [{path: "",label:"Blogs"}],
        }} />

        <main className='container-xl mb-5'>
            <div className="bg-light p-4 mb-3 d-flex gap-2 flex-wrap justify-content-center">
                {
                    blogCategories.map((cat, i) => (
                        <a
                            key={i}
                            onClick={() => handleCategorySelect(cat.slug)}
                            className={`btn btn-outline-dark px-2 py-1 fs-08 ${selectedCategory === cat.slug ? "active" : ""}`}
                            href="#"
                            role="button"
                        >{cat.name}</a>  
                    ))
                }              
            </div>
            {
                    loadingFilteredBlog ? (
                        <Loader fullHeight={false} />
                    ) : (
                        dataFilteredBlog.length === 0 ? (
                            <div className="alert alert-warning text-center w-100 d-flex flex-column align-items-center" role="alert">
                                <i className="bi bi-exclamation-triangle fs-3 mb-2"></i>
                                <strong>No matching products found.</strong><br />
                                Try adjusting your filters or
                                <button className="btn btn-link p-0 ms-1" onClick={resetFilters}>view all products</button>.
                            </div>
                        ):(
                            <>
                                <div className='row g-3'>
                                    {
                                        dataFilteredBlog.map((blog,i) => (
                                            <div className="col-lg-6" key={i}>
                                                <BlogPrimaryItem  blog={blog} />
                                            </div>
                                        ))
                                    }
                                </div>
                                {
                                    metaFilteredBlog.last_page > 1 && (
                                        <div className="d-flex justify-content-center mt-4">
                                            <ul className="pagination ">
                                                {Array.from({ length: metaFilteredBlog?.last_page || 1 }).map((_, i) => {
                                                    const pageNum = i + 1
                                                    const isActive = pageNum === metaFilteredBlog.current_page
                                                    return (
                                                        <li key={pageNum} className={`page-item ${pageNum === metaFilteredBlog?.current_page ? 'active' : ''}`}>
                                                            <button
                                                                className={`page-link ${isActive ? 'bg-danger border-danger text-white' : 'text-danger'}`}
                                                                onClick={() => setPage(pageNum)}
                                                            >
                                                                {pageNum}
                                                            </button>
                                                        </li>
                                                    );
                                                })}
                                            </ul>
                                        </div>
                                    )
                                }
                            </>
                        )
                    )
                }
        </main>
    </>
}
