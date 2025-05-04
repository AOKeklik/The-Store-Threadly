import React from 'react'
import Baner from '../../components/layouts/Baner'
import HeadingPrimary from '../../heading/HeadingPrimary'
import ButtonPrimary from '../../buttons/ButtonPrimary'
import ProductTitle from '../../heading/ProductTitle'

import useCart from '../../hooks/order/useCart'

export default function CartPage () {
    const {
        items,
        getDeliveryPrice,
        getDiscountAmount,
        getTotalPrice,
        totalQuantity,
        getItemPrice,
        getSubTotalPrice,
        getQuantity,
        getItemSubTotalPrice,
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
                <main className='container-lg mb-5'>
                    <div className="row g-5 align-items-start">
                        {/* ///////////// CART //////////// */}
                        <div className='table-responsive-lg col-lg-9'>
                            <table className="table table-borderless table-light table-hover table-striped mb-0">
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
                                                            <ProductTitle product={item} />
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

                        {/* ///////////// PAYMENT DETAIL //////////// */}
                        <div className='col-lg-3 bg-light'>
                            <div className="text-center px-3 py-4">
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
                                    <ButtonPrimary href="/checkout" text="Checkout" size='small' />
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
