import React from 'react'
import ButtonPrimary from '../buttons/ButtonPrimary'

import AnimateInView from '../hooks/AnimateInView'
import useFormSubscribe from '../hooks/form/useFormSubscribe'

export default function SubscriberForm() {
    const {
        formData,
        loading,
        errors,
        handleChange,
        
        handleSubmit
    } = useFormSubscribe()

  return <AnimateInView className='container-md bg-white py-3 px-5 z-3 position-relative shadow'>
        <form onSubmit={handleSubmit} className='row'>
            <div className="col-md-9 form-group">
                <input 
                    type="text"
                    name="email"
                    value={formData.email}
                    onChange={handleChange}
                    className={`form-control ${errors.email ? 'is-invalid' : ''}`}
                    placeholder='Enter your email addres'
                />
                {errors.email && (
                    <small className="text-danger">
                        {Array.isArray(errors.email) ? errors.email[0] : errors.email}
                    </small>
                )}
            </div>
            <div className='col-md-3'>
                <ButtonPrimary 
                    text={loading ? "Submitting..." : "Subscribe"}
                    type="submit"
                    disabled={loading}
                />
            </div>
        </form>
  </AnimateInView>
}
