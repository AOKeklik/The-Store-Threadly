import React from 'react'

export default function DisplayAttributes({product}) {
    return product.isVariant && (
        <div className='position-absolute bottom-0 end-0 d-flex gap-1 p-2'>
            {product.color && (
                <span 
                    className="badge px-2 border border-1" 
                    style={{ 
                        backgroundColor: product.color.value || '#ccc' 
                    }}
                    title={product.color.value}
                >
                    &nbsp;
                </span>
            )}
            {product.size && (
                <span className="badge bg-secondary">
                    {product.size.icon.toUpperCase()}
                </span>
            )}
        </div>
    )
}
