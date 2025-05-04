import React from 'react'
import { Link } from 'react-router-dom'

import Baner from '../../components/layouts/Baner'
import Loader from '../../components/layouts/Loader'
import BrandSlider from '../../slider/brand-slider/BrandSlider'
import ButtonAddToCart from '../../buttons/ButtonAddToCart'
import { URL_PRODUCT } from '../../config'

import useFetch from '../../hooks/useFetch'
import useWishlist from '../../hooks/order/useWishlist'

export default function WishlistPage() {
    const [ brands, loadingBrands ] = useFetch("slider/brand/all")
    const { 
        items,
        getItemPrice,
        
        isLoadingWishlist,
        isLoadingWishlistItem,

        isWishlistEmpty,
        isClearingWishlist,
        
        removeFromWishlist, 
        clearWishlist
    } = useWishlist()

    // console.log(items)

    return <main className='pb-5'>
        {
            <>
                <Baner {...{
                    title: "Wishlist Page",
                    breadcrumbs: [{path: "",label:"Wishlist"}],
                }} />
                
                <div id="page" className='container-xl mb-5 pb-5'>
                    {/* ///////////// CART //////////// */}
                    {
                        isLoadingWishlist ? (
                            <Loader fullHeight={false} />
                        ) : isWishlistEmpty ? (
                            <div className="card text-center shadow bg-light border-0">
                                <div className="card-body py-5">
                                    <h2 className="card-title mb-3">Your wishlist is currently empty</h2>
                                    <p className="card-text text-muted mb-4">
                                        Looks like you haven’t added anything to your cart yet. Start exploring our products and find something you love!
                                    </p>
                                    <a href="/products" className="btn btn-danger px-4 py-2">
                                        Continue Shopping
                                    </a>
                                </div>
                            </div>
                        ) : (
                            <div className='table-responsive-lg mb-5'>
                                <table className="table table-borderless table-light table-hover table-striped">
                                    <thead>
                                        <tr>
                                            <th scope="col" className='align-middle'>Product</th>
                                            <th scope="col" className='align-middle'>Price</th>
                                            <th scope="col" className='align-middle'>Stock</th>
                                            <th scope="col" className='align-middle'>Add</th>
                                            <th scope="col" className='align-middle'>
                                                {/* //////// CLEAR WISHLIST //////// */}
                                                <button 
                                                    disabled={isClearingWishlist()}
                                                    className='btn btn-outline-dark d-flex align-items-center gap-2' 
                                                    onClick={clearWishlist}
                                                >
                                                    {
                                                        isClearingWishlist() ? (
                                                            <>
                                                                <span className="spinner-grow spinner-grow-sm bg-danger" aria-hidden="true"></span>
                                                                Removing..
                                                            </>
                                                        ) : (
                                                            <>Remove</>
                                                        )
                                                    }
                                                </button>
                                                {/* //////// CLEAR WISHLIST //////// */}
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {
                                            items.map((item,i) => {
                                                return <tr key={i}>
                                                    {/* //////// IMG TITLE //////// */}
                                                    <td className="align-middle">
                                                        <div className='d-flex align-items-center gap-5'>
                                                            <img src={item.thumbnail} className='w-5' alt="" />
                                                            <div>
                                                                <Link
                                                                    to={`${URL_PRODUCT}/${item.slug}`}
                                                                    className="text-gray text-decoration-none hover-text-danger"
                                                                >
                                                                    <h6>{item.title}</h6>
                                                                </Link>
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
                                                    {/* //////// IMG TITLE //////// */}

                                                    {/* //////// PRICE //////// */}
                                                    <td className="align-middle">{getItemPrice(item)}</td>
                                                    {/* //////// PRICE //////// */}

                                                    {/* //////// STOCK //////// */}
                                                    <td className="align-middle">{item.stock}</td>
                                                    {/* //////// STOCK //////// */}

                                                    {/* //////// ADD TO CART //////// */}
                                                    <td className="align-middle">
                                                        <ButtonAddToCart product={item} />
                                                    </td>
                                                    {/* //////// ADD TO CART //////// */}

                                                    {/* //////// REMOVE WISHLIST //////// */}
                                                    <td className="align-middle">
                                                        <button
                                                            disabled={isLoadingWishlistItem(item)}
                                                            onClick={() => removeFromWishlist(item)}
                                                            className='btn hover-text-danger border-0 fs-5 p-0'
                                                        >
                                                            {
                                                                isLoadingWishlistItem(item) ? (
                                                                    <span className="spinner-grow spinner-grow-sm bg-danger" aria-hidden="true"></span>
                                                                ) : (
                                                                    <i className="bi bi-x-lg"></i>
                                                                )
                                                            }
                                                        </button>
                                                    </td>
                                                    {/* //////// REMOVE WISHLIST //////// */}
                                                </tr>
                                            })
                                        }
                                    </tbody>
                                </table>
                            </div>
                        )
                    }
                    {/* ///////////// CART //////////// */}
                </div>

                {
                    loadingBrands ? (
                        <Loader fullHeight={false} />
                    ) : (
                        <BrandSlider data={brands.data} />
                    )
                }
            </>
        }
    </main>
}
