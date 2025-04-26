import React from 'react'

import AnimateInView from '../hooks/AnimateInView'
import HeadingPrimary from '../components/layouts/HeadingPrimary'
import useFormContact from '../hooks/useFormContact'
import ButtonPrimary from '../buttons/ButtonPrimary'

export default function ContactForm() {
    const {
        formData,
        loading,
        errors,
        handleChange,
        
        handleSubmit
    } = useFormContact()

    return <AnimateInView className='row justify-content-center mb-5 pb-5'>
        <div className="col-md-8 col-lg-6">
            <div className="card shadow">
                <div className="card-header">
                    <HeadingPrimary title="CONTACT DETAILS" size='small' classname="p-2" />
                </div>
                <div className="card-body">
                    <form onSubmit={handleSubmit}>
                        <div className="mb-3">
                            <input 
                                type="text"
                                name="name"
                                value={formData.name}
                                onChange={handleChange}
                                className={`form-control ${errors.name ? 'is-invalid' : ''}`}
                                placeholder="Name and Surname"
                            />
                            {errors.name && (
                                <small className="text-danger">
                                    {Array.isArray(errors.name) ? errors.name[0] : errors.name}
                                </small>
                            )}
                        </div>
                        <div className="mb-3">
                            <input 
                                type="text"
                                name="email"
                                value={formData.email}
                                onChange={handleChange}
                                className={`form-control ${errors.email ? 'is-invalid' : ''}`}
                                placeholder="ornek@mail.com"
                            />
                            {errors.email && (
                                <small className="text-danger">
                                    {Array.isArray(errors.email) ? errors.email[0] : errors.email}
                                </small>
                            )}
                        </div>
                        <div className="mb-3">
                            <input
                                type="text" 
                                name="subject"
                                value={formData.subject}
                                onChange={handleChange}
                                className={`form-control ${errors.subject ? 'is-invalid' : ''}`}
                                placeholder="Subject"
                            />
                            {errors.subject && (
                                <small className="text-danger">
                                    {Array.isArray(errors.subject) ? errors.subject[0] : errors.subject}
                                </small>
                            )}
                        </div>
                        <div className="mb-3">
                            <textarea
                                name="message"
                                value={formData.message}
                                onChange={handleChange}
                                className={`form-control ${errors.message ? 'is-invalid' : ''}`}
                                rows="5" 
                                placeholder="Type your message..."
                            />
                            {errors.message && (
                                <small className="text-danger">
                                    {Array.isArray(errors.message) ? errors.message[0] : errors.message}
                                </small>
                            )}
                        </div>
                        <div>
                            <ButtonPrimary 
                                text={loading ? "Submitting..." : "Submit form"}
                                type="submit"
                                disabled={loading}
                            />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AnimateInView>
}
