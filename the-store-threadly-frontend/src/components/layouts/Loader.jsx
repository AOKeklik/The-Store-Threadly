import React from 'react'
import { BounceLoader  } from 'react-spinners' 

const Loader = ({fullHeight=true}) => {
    const containerClass=`
        w-100 d-flex justify-content-center align-items-center
        ${fullHeight ? 'vh-100' : 'py-5'}
    `
    return (
        <div className={containerClass}>
            <BounceLoader color='#09f' size={60} />  
        </div>
    )
}

export default Loader