import React from 'react'

export default function ProductItem({product}) {
    return <div className="card mb-3">
        <div className="row g-0">
            <div className="col-md-4">
                <img src={product.thumbnail} className="img-fluid rounded-start" alt={product.title} />
            </div>
            <div className="col-md-8">
                <div className="card-body">
                    <h5 className="card-title">{product.title}</h5>
                    {product.variants && product.variants.length > 0 && (
                        product.variants.map((variant, ii) => (
                        <div key={ii} className="mb-2">
                            <p className="mb-1"><strong>Price:</strong> {variant.price_html}</p>
                            <p className="mb-0"><strong>Stock:</strong> {variant.stock}</p>
                        </div>
                        ))
                    )}
                </div>
            </div>
        </div>
    </div>
}