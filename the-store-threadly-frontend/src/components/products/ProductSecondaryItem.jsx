import React from 'react'
import ButtonPrimary from '../buttons/ButtonPrimary'

export default function ProductSecondaryItem({product}) {
    return <>
        <div className="card border-light-subtle">
            <div className="card-header d-flex justify-content-between p-2 w-100 border-0">
                {
                    product.is_new > 0 && (
                        <span className="badge p-2 bg-danger">New</span>
                    )
                }
                <span dangerouslySetInnerHTML={{ __html: product.price_html }} />
            </div>
            <div className="card-body p-0">
                <img className='object-fit-contain' src={product.thumbnail} alt="" />
            </div>
            <div className="card-footer d-flex justify-content-between p-2 border-0 ">
                <div>
                    <a href={`product/${product.slug}`} className="text-gray text-decoration-none hover-text-danger">
                        <h3 className='fs-6 p-0 m-0'>{product.title}</h3>
                    </a>
                    <small>{product.category_name}</small>
                </div>
                <ButtonPrimary text="BUY NOW" size='small' />
            </div>
        </div>
    </>
}