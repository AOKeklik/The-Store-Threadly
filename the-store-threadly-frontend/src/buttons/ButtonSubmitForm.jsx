import React from 'react'

export default function ButtonSubmitForm({loading=false,text="Send"}) {
    return <button 
        type="submit" 
        className="btn btn-danger d-flex gap-2 justify-content-center align-items-center"
    >
        {
            loading ? (
                <>
                    <span className="spinner-grow spinner-grow-sm" aria-hidden="true"></span>
                    Loading...
                </>
            ) : (
                text
            )
        }
    </button>
}
