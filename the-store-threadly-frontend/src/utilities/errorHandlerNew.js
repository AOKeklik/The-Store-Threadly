export const handleError = (err) => {
    if (err.response) {
        const { status, data } = err.response

        // Handle validation errors
        if (status === 422) {
            return {
                success: data.success,
                type: data.error_type,
                message: data.message,
                errors: data.errors,
            }
        }

        // Handle Unauthorized errors
        if (status === 401) {
            return {
                success: data.success,
                type: data.error_type,
                message: data.message,
                error: data.error,
            }
        }

        if (status === 404) {
            return {
                success: data.success,
                type: data.error_type,
                message: data.message,
                error: data.error,
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