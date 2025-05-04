import { useState, useRef, useCallback } from 'react'
import { Link } from 'react-router-dom'
import './CartPopover.css'

import useCart from '../hooks/order/useCart'

export default function DisplayCartPopover() {
    const [isVisible, setIsVisible] = useState(false)
    const hoverTimeoutRef = useRef(null)

    const { 
        items,
        getItemPrice,
        getSubTotalPrice,
        totalQuantity, 
        isCartEmpty,
    } = useCart()

    const clearHoverTimeout = () => {
        if (hoverTimeoutRef.current) {
            clearTimeout(hoverTimeoutRef.current)
            hoverTimeoutRef.current = null
        }
    }

    const showCartPopover = useCallback(() => {
        clearHoverTimeout()
        setIsVisible(true)
    }, [])

    const hideCartPopover = useCallback(() => {
        clearHoverTimeout()
        hoverTimeoutRef.current = setTimeout(() => {
            setIsVisible(false)
            hoverTimeoutRef.current = null
        }, 300)
    }, [])

    return (
        <div
            role="button"
            className="d-flex align-items-center position-relative"
            onMouseEnter={showCartPopover}
            onMouseLeave={hideCartPopover}
        >
            <button className="position-relative text-secondary hover-text-gray-800 border-0 p-0">
                <i className="bi bi-cart-fill"></i>
                <span className="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                    {totalQuantity}
                </span>
            </button>

            {isVisible && (
                <div
                    className="section-popover"
                    onMouseEnter={showCartPopover}
                    onMouseLeave={hideCartPopover}
                    style={{
                        position: 'absolute',
                        top: '100%',
                        right: 0,
                        zIndex: 1000,
                    }}
                >
                    {
                        !isCartEmpty && (
                            <h5 className='text-center mb-3'>Your Cart</h5>
                        )
                    }
                    <div className="popover-items">
                        {!isCartEmpty ? (
                            items.map(item => (
                                <div key={item.uniqueId} className="popover-item">
                                    <img src={item.thumbnail} alt={item.title} />
                                    <div className="item-details">
                                        <Link
                                            to={`product/${item.slug}`}
                                            className="text-gray text-decoration-none hover-text-danger"
                                        >
                                            <h6>{item.title}</h6>
                                        </Link>
                                        <p>{item.quantity} × {getItemPrice(item)}</p>
                                    </div>
                                </div>
                            ))
                        ) : (
                            <p className="empty-cart popover-item">Empty</p>
                        )}
                    </div>

                    {items.length > 0 && (
                        <div className="popover-footer">
                            <div className="text-start mb-2">
                                <span className="fw-bold">Sub Total: </span>{getSubTotalPrice()}
                            </div>
                            <Link to="/cart" className="btn btn-primary">
                                Go to Cart ({totalQuantity})
                            </Link>
                        </div>
                    )}
                </div>
            )}
        </div>
    )
}
