import React from 'react'
import ButtonPrimary from '../buttons/ButtonPrimary'

import useSubscribeForm from '../hooks/useSubscribeForm'
import AnimateInView from '../hooks/AnimateInView'

export default function Subscriber() {
    const {
        formData,
        loading,
        errors,
        handleChange,
        
        handleSubmit
    } = useSubscribeForm()

  return <AnimateInView className='container-md bg-white py-3 px-5 z-3 position-relative shadow'>
        <form onSubmit={handleSubmit} className='row'>
            <div className="col-md-9 form-group">
                <input 
                    type="text"
                    name="email"
                    value={formData.email}
                    onChange={handleChange}
                    placeholder='Enter your email addres'
                    className={`form-control ${errors.email ? 'is-invalid' : ''}`}
                />
                {errors.email && <small className="text-danger">{errors.email}</small>}
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
