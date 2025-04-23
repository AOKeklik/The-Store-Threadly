import { useDispatch, useSelector } from 'react-redux'
import { setFilter, resetFilters } from '../redux/filterSlice'

export default function useFilters () {
    const dispatch = useDispatch()
    const activeFilters = useSelector((state) => state.filters)

    /**
     * Toggles a filter on/off (radio button behavior)
     * @param {string} filterType - The filter category ('color', 'size', etc.)
     * @param {string} value - The filter value to toggle
     */
    const toggleFilter = (filterType, value) => {
        dispatch(setFilter({ key: filterType, value }))
    }

    /**
     * Checks if a specific filter is currently active
     * @param {string} filterType - The filter category
     * @param {string} value - The filter value to check
     * @returns {boolean} - Whether the filter is active
     */
    const isFilterActive = (filterType, value) => {
        return activeFilters[filterType] === value
    }

    /**
     * Clears all filters
     */
    const clearAllFilters = () => {
        dispatch(resetFilters())
    }

    return {
        activeFilters,
        toggleFilter,
        isFilterActive,
        clearAllFilters,
    }
}