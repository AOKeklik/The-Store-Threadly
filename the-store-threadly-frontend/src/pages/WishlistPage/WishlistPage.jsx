import React from 'react'

import Baner from '../../components/layouts/Baner'
import Loader from '../../components/layouts/Loader'
import BrandSlider from '../../slider/brand-slider/BrandSlider'
import useFetch from '../../hooks/useFetch'
import useWishlist from '../../hooks/useWishlist'
import useCart from '../../hooks/useCart'
import ButtonAddToCart from '../../buttons/ButtonAddToCart'
import { Link } from 'react-router-dom'
import { URL_PRODUCT } from '../../config'

export default function WishlistPage() {
    const [ brands, loadingBrands ] = useFetch("slider/brand/all")
    const {getItemPrice} = useCart()
    const { items, isWishlistEmpty, removeFromWishlist, wishlistLoading, isInWishlist } = useWishlist()

    return <main className='pb-5'>
        {
            loadingBrands || wishlistLoading ? (
                <Loader fullHeight={false} />
            ) : (
                <>
                    <Baner {...{
                        title: "Wishlist Page",
                        breadcrumbs: [{path: "",label:"Wishlist"}],
                    }} />
                    
                    <div id="page" className='container-xl mb-5 pb-5'>
                        {/* ///////////// CART //////////// */}
                        {
                            isWishlistEmpty() ? (
                                <div class="card text-center shadow bg-light border-0">
                                    <div class="card-body py-5">
                                        <h2 class="card-title mb-3">Your wishlist is currently empty</h2>
                                        <p class="card-text text-muted mb-4">
                                            Looks like you haven’t added anything to your cart yet. Start exploring our products and find something you love!
                                        </p>
                                        <a href="/products" class="btn btn-danger px-4 py-2">
                                            Continue Shopping
                                        </a>
                                    </div>
                                </div>
                            ) : (
                                <div className='table-responsive-lg mb-5'>
                                    <table className="table table-borderless table-light table-hover table-striped">
                                        <thead>
                                            <tr>
                                                <th scope="col">Product</th>
                                                <th scope="col">Price</th>
                                                <th scope="col">Stock</th>
                                                <th scope="col">Add</th>
                                                <th scope="col">Remove</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {
                                                items.map((item,i) => {
                                                    return <tr key={i}>
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
                                                        <td className="align-middle">{getItemPrice(item)}</td>
                                                        <td className="align-middle">{item.stock}</td>
                                                        <td className="align-middle">
                                                            <ButtonAddToCart product={item} />
                                                        </td>
                                                        <td className="align-middle">
                                                            <button 
                                                                onClick={() => removeFromWishlist(item)}
                                                                className='btn hover-text-danger border-0 fs-5 p-0'
                                                            >
                                                                <i className="bi bi-x-lg"></i>
                                                            </button>
                                                        </td>
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

                    <BrandSlider data={brands.data} />
                </>
            )
        }
    </main>
}
