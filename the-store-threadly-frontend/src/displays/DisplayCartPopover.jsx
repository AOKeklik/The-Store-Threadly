import { useState, useRef, useCallback } from 'react';
import { Link } from 'react-router-dom';
import useCart from '../hooks/useCart';
import './CartPopover.css';

export default function DisplayCartPopover() {
    const [isVisible, setIsVisible] = useState(false);
    const hoverTimeoutRef = useRef(null);

    const { items, totalQuantity, getItemPrice, getSubTotalPrice } = useCart();

    const clearHoverTimeout = () => {
        if (hoverTimeoutRef.current) {
            clearTimeout(hoverTimeoutRef.current);
            hoverTimeoutRef.current = null;
        }
    };

    const showCartPopover = useCallback(() => {
        clearHoverTimeout();
        setIsVisible(true);
    }, []);

    const hideCartPopover = useCallback(() => {
        clearHoverTimeout();
        hoverTimeoutRef.current = setTimeout(() => {
            setIsVisible(false);
            hoverTimeoutRef.current = null;
        }, 300);
    }, []);

    return (
        <div
            role="button"
            className="d-flex align-items-center position-relative"
            onMouseEnter={showCartPopover}
            onMouseLeave={hideCartPopover}
        >
            <a href="javascript:void(0)" className="position-relative text-secondary hover-text-gray-800">
                <i className="bi bi-cart-fill"></i>
                <span className="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                    {totalQuantity}
                </span>
            </a>

            {isVisible && (
                <div
                    id="section-cart-popoup"
                    className="cart-popover"
                    onMouseEnter={showCartPopover}
                    onMouseLeave={hideCartPopover}
                    style={{
                        position: 'absolute',
                        top: '100%',
                        right: 0,
                        zIndex: 1000,
                    }}
                >
                    <h5>Your Cart</h5>
                    <div className="cart-items">
                        {items.length > 0 ? (
                            items.map(item => (
                                <div key={item.uniqueId} className="cart-item">
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
                            <p className="empty-cart">Your cart is empty</p>
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
    );
}
