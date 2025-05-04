import React from 'react'

import Baner from '../../components/layouts/Baner'
import HeadingPrimary from '../../heading/HeadingPrimary'
import {useSettings} from "../../context/settingContext"
import ContactForm from '../../form/ContactForm'

export default function ContactPage() {
    const { settings } = useSettings()

    return <main>
        {
            <>
                <Baner {...{
                    title: "Contact Us",
                    // cover: data.cover,
                    breadcrumbs: [{path: "",label: "Contact Us"}],
                }} />

                <div id="page-contact" className='container-xl mb-5 pb-5'>
                    <div className="row justify-content-center align-items-center">
                        <div className="col-md-6">
                            <HeadingPrimary title="CONTACT DETAILS" size='small' classname='mb-3' />
                            <div className='d-flex flex-column gap-4'>
                                <div className='d-flex gap-4 align-items-center'>
                                    <div className='bg-secondary py-1 px-2 rounded-3'>
                                        <i className="bi bi-geo-alt-fill text-white"></i>
                                    </div>
                                    <span dangerouslySetInnerHTML={{ __html: settings.site_address }} />
                                </div>
                                <div className='d-flex gap-4 align-items-center'>
                                    <div className='bg-secondary py-1 px-2 rounded-3'>
                                    <i className="bi bi-telephone-fill  text-white"></i>
                                    </div>
                                    <span dangerouslySetInnerHTML={{ __html: settings.site_phone }} />
                                </div>
                                <div className='d-flex gap-4 align-items-center'>
                                    <div className='bg-secondary py-1 px-2 rounded-3'>
                                        <i className="bi bi-envelope-fill text-white"></i>
                                    </div>
                                    <span dangerouslySetInnerHTML={{ __html: settings.site_email }} />
                                </div>
                            </div>
                        </div>
                        <div className="col-md-6">
                            <div dangerouslySetInnerHTML={{ __html: settings.site_map }} />
                        </div>
                    </div>
                </div>

                <ContactForm />
            </>
        }
    </main>
}
