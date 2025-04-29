import React from 'react'
import Baner from '../../components/layouts/Baner'
import useCart from '../../hooks/useCart'
import HeadingPrimary from '../../components/layouts/HeadingPrimary'
import ButtonPrimary from '../../buttons/ButtonPrimary'

export default function CartPage () {
    const {
        items,
        totalQuantity,
        getQuantity,
        getDeliveryPrice,
        getDiscountPrice,
        getItemPrice,
        getItemSubTotalPrice,
        getSubTotalPrice,
        getTotalPrice,
        increaseQuantity,
        decreaseQuantity,
        removeFromCart,
        clearCart,
    } = useCart()

    return <div className='pb-5'>
        <Baner {...{
            title: "Cart",
            breadcrumbs: [
                {path:"",label:"Cart"}
            ],
        }} />
    
        {
            totalQuantity === 0 ? (
                <div className="card text-center shadow bg-light border-0">
                    <div className="card-body py-5">
                        <h2 className="card-title mb-3">Your cart is currently empty</h2>
                        <p className="card-text text-muted mb-4">
                            Looks like you haven’t added anything to your cart yet. Start exploring our products and find something you love!
                        </p>
                        <a href="/products" className="btn btn-danger px-4 py-2">
                            Continue Shopping
                        </a>
                    </div>
                </div>
            ) : ( 
                <main className='container-md mb-5'>
                    {/* ///////////// CART //////////// */}
                    <div className='table-responsive-lg mb-5'>
                        <table className="table table-borderless table-light table-hover table-striped">
                            <thead>
                                <tr>
                                    <th scope="col" className='align-middle'>Product</th>
                                    <th scope="col" className='align-middle'>Price</th>
                                    <th scope="col" className='align-middle'>Quantity</th>
                                    <th scope="col" className='align-middle'>Total</th>
                                    <th scope="col" className='align-middle'>
                                        <button className='btn btn-outline-dark' onClick={clearCart}>
                                            Remove
                                        </button>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                {
                                    items.map((item,i) => {
                                        return <tr key={i}>
                                            {/* /////// IMG & TITLE /////// */}
                                            <td className="align-middle">
                                                <div className='d-flex align-items-center gap-5'>
                                                    <img src={item.thumbnail} className='w-5' alt="" />
                                                    <div>
                                                        <h6>{item.title}</h6>
                                                        {
                                                            item.color && (
                                                                <div>
                                                                    <span className='fw-bold'>Color:</span> <span>{item.color.value}</span>
                                                                </div>
                                                            )
                                                        }
                                                        {
                                                            item.size && (
                                                                <div>
                                                                    <span className='fw-bold'>Size:</span> <span>{item.size.value}</span>
                                                                </div>
                                                            )
                                                        }
                                                    </div>
                                                </div>
                                            </td>
                                            {/* /////// IMG & TITLE /////// */}

                                            {/* /////// PRICE /////// */}
                                            <td className="align-middle">{getItemPrice(item)}</td>
                                            {/* /////// PRICE /////// */}


                                            {/* /////// QUANTITY BUTTONS /////// */}
                                            <td className="align-middle">
                                                <div className="rounded d-flex gap-1">
                                                    <button 
                                                        onClick={() => decreaseQuantity(item)}
                                                        className='btn bg-light p-3 hover-text-danger'
                                                    >
                                                        <i className="bi bi-dash-lg"></i>
                                                    </button>
                                                    <span className='bg-light px-2 py-3'>
                                                        {getQuantity(item)}
                                                    </span>
                                                    <button 
                                                        onClick={() => increaseQuantity(item)}
                                                        className='btn bg-light p-3 hover-text-danger'
                                                    >
                                                        <i className="bi bi-plus-lg"></i>
                                                    </button>
                                                </div>  
                                            </td>
                                            {/* /////// QUANTITY BUTTONS /////// */}

                                            {/* /////// SUB TOTAL PRICE /////// */}
                                            <td className="align-middle">{getItemSubTotalPrice(item)}</td>
                                            {/* /////// SUB TOTAL PRICE /////// */}

                                            {/* /////// REMOVE BUTTON /////// */}
                                            <td className="align-middle">
                                                <button 
                                                    onClick={() => removeFromCart(item)}
                                                    className='btn hover-text-danger border-0 fs-5 p-0'
                                                >
                                                    <i className="bi bi-x-lg"></i>
                                                </button>
                                            </td>
                                            {/* /////// REMOVE BUTTON /////// */}
                                        </tr>
                                    })
                                }
                            </tbody>
                        </table>
                    </div>
                    {/* ///////////// CART //////////// */}

                    <div className='row g-5'>
                        {/* ///////////// COUPON //////////// */}
                        <div className='col-md-6'>
                            <div className='p-3 bg-white'>
                                <HeadingPrimary title="COUPON DISCOUNT" size='small' classname="mb-3" />
                                <p className='mb-3'>Enter your coupon code if you have one!</p>
                                <div className='mb-3'>
                                    <input className='form-control' type="text" name='' placeholder='Enter your code here.' />
                                </div>
                                <ButtonPrimary text="Apply Coupon" size='small' />
                            </div>
                        </div>
                        {/* ///////////// COUPN //////////// */}

                        {/* ///////////// PAYMENT DETAIL //////////// */}
                        <div className='col-md-6'>
                            <div className="bg-white text-center p-3 h-100">
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
                                        <span className=''>{getDiscountPrice()}</span>
                                    </p>
                                    <p className='d-flex gap-2 justify-content-between mb-3'>
                                        <span className='fw-bold'>Total:</span>
                                        <span className=''>{getTotalPrice()}</span>
                                    </p>
                                    <ButtonPrimary text="Checkout" size='small' />
                                </div>
                            </div>
                        </div>
                        {/* ///////////// PAYMENT DETAIL //////////// */}
                    </div>
                </main>
            )
        }
    </div>
}
