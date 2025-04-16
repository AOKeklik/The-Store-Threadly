import React from 'react'
import ButtonPrimary from '../buttons/ButtonPrimary'

import useSubscribeForm from '../hooks/useSubscribeForm'
import AnimateInView from '../hooks/AnimateInView'

export default function Subscribe() {
    const {
        formData,
        errors,
        handleChange,
        validate,
        resetForm
    } = useSubscribeForm()

    const handleSubmit = (e) => {
        e.preventDefault()

        if (validate()) {
            console.log('Sending data...', formData)
            resetForm()
        }
    }

  return <AnimateInView className='container-md bg-white py-3 px-5 z-3 position-relative shadow'>
        <form onSubmit={handleSubmit} className='row'>
            <div className="col-md-9 form-group">
                <input 
                    type="text"
                    name="email"
                    value={formData.email}
                    onChange={handleChange}
                    placeholder='Enter your email addres' 
                    className="form-control"
                />
                {errors.email && <small className="text-danger">{errors.email}</small>}
            </div>
            <div className='col-md-3'>
                <ButtonPrimary text="subscribe" type="submit" />
            </div>
        </form>
  </AnimateInView>
}
