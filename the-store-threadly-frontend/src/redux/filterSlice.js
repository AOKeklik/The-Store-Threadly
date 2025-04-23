import { createSlice } from '@reduxjs/toolkit';

const initialState = {
    color: '',
    size: '',
    gender: '',
    category: ''
};

const filtersSlice = createSlice({
    name: 'filters',
    initialState,
    reducers: {
        // Toggle filter on/off (radio button behavior)
        setFilter: (state, action) => {
            const { key, value } = action.payload;
            state[key] = state[key] === value ? '' : value;
        },
        
        // Reset all filters
        resetFilters: () => initialState,
    }
});

export const { 
    setFilter, 
    resetFilters 
} = filtersSlice.actions;
export default filtersSlice.reducer;


// dispatch(setFilter({ key: 'color', value: 'red' }));
// dispatch(resetFilters());