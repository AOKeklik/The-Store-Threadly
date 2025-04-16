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
        setFilter: (state, action) => {
            const { key, value } = action.payload;
            state[key] = value;
        },
        resetFilters: () => initialState
    }
});

export const { setFilter, resetFilters } = filtersSlice.actions;
export default filtersSlice.reducer;


// dispatch(setFilter({ key: 'color', value: 'red' }));
// dispatch(resetFilters());