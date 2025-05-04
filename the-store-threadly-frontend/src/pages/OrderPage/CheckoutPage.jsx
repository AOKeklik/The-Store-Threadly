import React from 'react'
import Baner from '../../components/layouts/Baner'
import HeadingPrimary from '../../heading/HeadingPrimary'
import ButtonPrimary from '../../buttons/ButtonPrimary'

import useCoupon from '../../hooks/order/useCoupon'
import useCheckout from './../../hooks/order/useCheckout';
import Loader from '../../components/layouts/Loader'

export default function CheckoutPage() {
    const {
        isSelectedDeliveryMethod,
        handleChangeDelivery,

        deliveryMethods,
        isLoadingDeliveryMethods,

        getSubTotalPrice,
        getDeliveryPrice,
        getDiscountAmount,
        getTotalPrice,
    } = useCheckout ()

    const {
        coupon,
        isApplied,
        isLoadingProfile,
        handleRemoveCoupon,
        formData,
        errors,
        handleChange,
        handleSubmitCouponFom
    } = useCoupon ()

    return <div className='pb-5'>
        <Baner {...{
            title: "Checkout",
            breadcrumbs: [
                {path:"/cart",label:"Cart"},
                {path:"",label:"Checkout"},
            ],
        }} />

        <main className='container-lg mb-5'>
            <div className='row g-5'>
                <div className='col-md-6'>
                    <div className="row g-3">
                        {/* ///////////// DELIVERY //////////// */}
                        <div className='p-3 bg-light'>
                            {
                                isLoadingDeliveryMethods || deliveryMethods.length === 0  ? (
                                    <Loader fullHeight={false} />
                                ) : (
                                    <>  
                                        <HeadingPrimary title="DELIVERY METHODS" size='small' classname="mb-3" />
                                        <div className="d-flex flex-column-reverse gap-3">
                                        {
                                            deliveryMethods.map((item,i) => (
                                                <label 
                                                    htmlFor={`delivery-method-${item.id}`} 
                                                    className="form-check-label border p-3 rounded bg-white" 
                                                    key={i}
                                                >
                                                    <div className='form-check d-flex gap-3'>
                                                        <input 
                                                            id={`delivery-method-${item.id}`}
                                                            name="deliveryMethod"
                                                            value={item.id}
                                                            checked={isSelectedDeliveryMethod(item.id)}
                                                            onChange={handleChangeDelivery}
                                                            className="form-check-input" 
                                                            type="radio" 
                                                        />
                                                        <strong>{item.name}</strong><br />
                                                    </div>
                                                    {item.desc}
                                                </label>  
                                            ))
                                        }                              
                                    </div>
                                    </>
                                )
                            }
                        </div>
                        {/* ///////////// DELIVERY //////////// */}

                        {/* ///////////// COUPON FORM //////////// */}
                        <form 
                            onSubmit={handleSubmitCouponFom}
                            className='p-3 bg-light'
                        >
                            <HeadingPrimary title="COUPON DISCOUNT" size='small' classname="mb-3" />
                            <p className='mb-3'>Enter your coupon code if you have one!</p>
                            <div className='mb-3'>
                                <div className="position-relative">
                                    <input
                                        readOnly={isApplied}
                                        name="code"
                                        value={formData.code}
                                        onChange={handleChange}
                                        className={`form-control ${errors.code ? "is-invalid" : ""}`}
                                        type="text" placeholder='Enter your code here.'
                                    />
                                    {
                                        isApplied && (
                                            <span 
                                                className="position-absolute top-50 end-0 translate-middle-y me-3 text-danger"
                                                role="button"
                                                onClick={handleRemoveCoupon}
                                            >
                                                &times;
                                            </span>
                                        )
                                    }
                                </div>
                                {(errors.code || errors.cart_sub_total) && (
                                    <small className='text-danger'>
                                        {errors.code && (Array.isArray(errors.code) ? errors.code[0] : errors.code)}
                                        {errors.cart_sub_total && (Array.isArray(errors.cart_sub_total) ? errors.cart_sub_total[0] : errors.cart_sub_total)}
                                    </small>
                                )}
                            </div>
                            <div className="d-flex gap-3 align-items-center">
                                <ButtonPrimary type='submit' text="Apply Coupon" size='small' />
                                {
                                    isLoadingProfile && (
                                        <div className="spinner-border text-danger" role="status">
                                            <span className="visually-hidden">Loading...</span>
                                        </div>
                                    )
                                }
                            </div>
                        </form>
                        {/* ///////////// COUPN FORM //////////// */}
                    </div>
                </div>

                {/* ///////////// PAYMENT DETAIL //////////// */}
                <div className='col-md-6'>
                    <div className="text-center p-3 bg-light">
                        <HeadingPrimary title="PAYMENT DETAILS" size='small' classname="mb-3" />
                        <div className='max-w-15 mx-auto'>
                            <p className='d-flex gap-2 justify-content-between mb-3'>
                                <span className='fw-bold'>Sub Total:</span>
                                <span className=''>{getSubTotalPrice()}</span>
                            </p>
                            <p className='d-flex gap-2 justify-content-between mb-3'>
                                <span className='fw-bold'>Delivery:</span>
                                <span className=''>{getDeliveryPrice()}</span>
                            </p>
                            <p className='d-flex gap-2 justify-content-between mb-3'>
                                <span className='fw-bold'>Discount:</span>
                                <span className=''>{getDiscountAmount()}</span>
                            </p>
                            <p className='d-flex gap-2 justify-content-between mb-3'>
                                <span className='fw-bold'>Total:</span>
                                <span className=''>{getTotalPrice()}</span>
                            </p>
                            <ButtonPrimary href="/payment" text="payment" size='small' />
                        </div>
                    </div>
                </div>
                {/* ///////////// PAYMENT DETAIL //////////// */}
            </div>
        </main>
    </div>
}
