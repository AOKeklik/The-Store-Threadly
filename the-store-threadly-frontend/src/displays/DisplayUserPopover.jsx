import { useState, useRef, useCallback } from 'react';
import { Link } from 'react-router-dom';
import './CartPopover.css';
import { useAuth } from '../hooks/useAuth';

export default function DisplayUserPopover() {
    const {isAuthenticated, user, isLoggingOut, logout} = useAuth ()
    const [isVisible, setIsVisible] = useState(false);
    const hoverTimeoutRef = useRef(null);

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
                <i className="bi bi-person-fill fs-4"></i>
            </a>

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
                    <h6>{user.name}</h6>
                    <div className="popover-items">
                        {
                            /* LOGIN */
                            isAuthenticated ? (
                                <>
                                    <Link to="/dashboard"  className="text-secondary hover-text-gray-800 text-decoration-none gap-2 popover-item">
                                        <i className="bi bi-house-fill"></i>
                                        Dashboard
                                    </Link>
                                    <button 
                                        onClick={logout}  
                                        disabled={isLoggingOut}
                                        className="btn text-secondary hover-text-gray-800 text-decoration-none gap-2 popover-item fw-medium"
                                    >
                                        {
                                            isLoggingOut ? (
                                                <span className="spinner-grow spinner-grow-sm" aria-hidden="true"></span>
                                            ) : (
                                                <i className="bi bi-door-closed-fill"></i>
                                            )
                                        }
                                        Signout
                                    </button>
                                </>
                            ) : (
                                /* LOGOUT */
                                <Link to="/signin"  className="text-secondary hover-text-gray-800 text-decoration-none gap-2 popover-item">
                                    <i className="bi bi-person-fill fs-4"></i>
                                    Login
                                </Link>
                            )
                        }
                    </div>
                </div>
            )}
        </div>
    );
}
