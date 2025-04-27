export const handleError = (err) => {
    if (err.response) {
        const { status, data } = err.response

        // Handle validation errors
        if (status === 422) {
            return {
                type: 'validation',
                errors: data.message,
            }
        }

        // Handle Unauthorized errors
        if (status === 401) {
            return {
                type: 'credential',
                message: data.message || 'Unauthorized. Please check your credentials.',
            }
        }

        // Handle other errors
        return {
            type: 'general',
            message: data.message || 'Something went wrong.',
        }
    }

    // Handle other errors
    return {
        type: 'general',
        message: err.message || 'Network error. Please try again later.',
    }
}

export const handleActionError = (state, action, key) => {
    if (action.payload.type === 'validation') {
        state[key].validationErrors = action.payload.errors

    } else if (action.payload.type === 'credential') {

        state[key].error = action.payload.message;

    } else {
        
        state[key].error = action.payload.message
    }
};