import React from 'react'

import Baner from '../../components/layouts/Baner'
import Loader from '../../components/layouts/Loader'

import useBlog from '../../hooks/useBlog'
import { useParams } from 'react-router-dom'
import BlogSlider from '../../slider/blog-slider/BlogSlider'

export default function BlogSinglePage() {
    const { slug } = useParams()
    const {
        dataBlog,
        dataRelatedBlog,
        loadingBlog
    } = useBlog(slug)

    console.log(dataBlog)

    return <>
        <Baner {...{
            title: dataBlog.title,
            cover: dataBlog.cover,
            breadcrumbs: [
                {path: `/blogs`,label:"Blogs"},
                {path: "",label:dataBlog.title}
            ],
        }} />

        <main className='container-md'>
            {
                loadingBlog ? (
                    <Loader fullHeight={false} />
                ) : (
                    <div className='p-3 bg-light rounded-1 mb-5'>
                        <div className='mb-5 position-relative'>
                            <img src={dataBlog.thumbnail} alt="" className='w-100 h-35rem object-fit-cover' />
                            <div className='position-absolute top-0 start-0 p-2 d-flex gap-3 bg-white rounded-top-1 m-3'>
                                <div className='d-flex flex-column gap-1 justify-content-center align-items-center text-danger fw-bold lh-1 p-2'>
                                    <span className='fs-5'>{dataBlog.created_day}</span>
                                    <span className='fs-4'>{dataBlog.created_month.toUpperCase()}</span>
                                </div>
                            </div>
                            <div className='position-absolute bottom-0 start-0 p-2 d-flex gap-3 bg-white rounded-top-1'>
                                <div className='d-flex gap-1 fs-08'>
                                    <i className='bi bi-person'></i>
                                    {dataBlog.author}
                                </div>
                                <div className='d-flex gap-1 fs-08'>
                                    <i className='bi bi-heart'></i>
                                    89
                                </div>
                                <div className='d-flex gap-1 fs-08'>
                                    <i className='bi bi-chat-dots'></i>
                                    23
                                </div>
                                <div className='d-flex gap-1 fs-08'>
                                    <i className='bi bi-share'></i>
                                    19
                                </div>
                            </div>
                        </div>
                        <div>
                            <h1 className='mb-4 fs-2'>{dataBlog.title}</h1>
                            <div dangerouslySetInnerHTML={{ __html: dataBlog.desc }} />
                        </div>
                    </div>
                )   
            }
            {
                <BlogSlider data={dataRelatedBlog} />
            }
        </main>
    </>
}
