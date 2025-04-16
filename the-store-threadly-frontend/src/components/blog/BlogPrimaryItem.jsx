import React from 'react'

export default function BlogPrimaryItem({blog}) {
    return <div className="section-product-item">
        <div className="card">
            <div className="card-body d-flex flex-column flex-md-row justify-content-between p-0">
                <div className="p-3 w-50">
                    <div className='d-flex align-items-center gap-2 pb-3'>
                        <span className='border border-danger py-2 px-3 text-danger'>{blog.created_day}</span>
                        <div className='d-flex flex-column'>
                            <span className='text-danger fw-bold'>{blog.created_date}</span>
                            <span role="button" tabIndex="0" className='text-uppercase hover-text-danger'>{blog.title}</span>
                        </div>
                    </div>
                    <div className="d-flex gap-4 pb-4 fs-08">
                        <span role="button" tabIndex="0" className='hover-text-danger'>
                            <i className="bi bi-heart"></i> 89
                        </span> 
                        <span role="button" tabIndex="0" className='hover-text-danger'>
                            <i className="bi bi-hand-thumbs-up"></i> 59
                        </span>
                        <span role="button" tabIndex="0" className='hover-text-danger'>
                            <i className="bi bi-chat-dots"></i> 29
                        </span>
                        <span role="button" tabIndex="0" className='hover-text-danger'>
                            <i className="bi bi-share"></i> Share
                        </span>
                    </div>
                    <p className='fs-09 pb-3'>{blog.excerpt}</p>
                    <p role="button" tabIndex="0" className='fs-09 text-danger'>Read More..</p>
                </div>
                <div className='w-50'>
                    <img className='w-100 h-100 object-fit-cover' src={blog.thumbnail} alt="" />
                </div>
            </div>
        </div>
    </div>
}
