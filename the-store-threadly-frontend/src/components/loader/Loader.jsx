import React from 'react'
import { BounceLoader  } from 'react-spinners' 

const Loader = ({fullHeight=true}) => {
    const containerClass=`
        w-full flex justify-center items-center
        ${fullHeight ? 'h-screen' : 'py-10'}
    `
    return (
        <div className={containerClass}>
            <BounceLoader color='#09f' size={60} />  
        </div>
    )
}

export default Loader