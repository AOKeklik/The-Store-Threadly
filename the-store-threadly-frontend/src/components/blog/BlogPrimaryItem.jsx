import React from 'react'
import { URL_BLOG } from './../../config';
import { Link } from 'react-router-dom';

export default function BlogPrimaryItem({ blog }) {
    return <div className="card">
        <div className="card-body d-flex flex-column flex-md-row justify-content-between p-0">
            <div className="p-3 w-50">
                <div className='d-flex align-items-center gap-2 pb-3'>
                    <span className='border border-danger py-2 px-3 text-danger'>{blog.created_day}</span>
                    <div className='d-flex flex-column'>
                        <span className='text-danger fw-bold'>{blog.created_date}</span>
                        <Link to={`${URL_BLOG}/${blog.slug}`} role="button" tabIndex="0" className='text-uppercase hover-text-danger text-dark text-decoration-none'>{blog.title}</Link>
                    </div>
                </div>
                <div className="d-flex gap-4 pb-4 fs-08">
                    <span tabIndex="0">
                        <i className="bi bi-heart"></i> 89
                    </span> 
                    <span tabIndex="0">
                        <i className="bi bi-hand-thumbs-up"></i> 59
                    </span>
                    <span tabIndex="0">
                        <i className="bi bi-chat-dots"></i> 29
                    </span>
                    <span tabIndex="0">
                        <i className="bi bi-share"></i> 29
                    </span>
                </div>
                <p className='fs-09 pb-3'>{blog.excerpt}</p>
                <Link to={`${URL_BLOG}/${blog.slug}`} role="button" tabIndex="0" className='fs-09 text-danger'>Read More..</Link>
            </div>
            <div className='w-50'>
                <img className='w-100 h-100 object-fit-cover' src={blog.thumbnail} alt="" />
            </div>
        </div>
    </div>
}
