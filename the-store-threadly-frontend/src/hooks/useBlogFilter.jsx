import { useState } from "react";

export default function useBlogFilter() {
    const initialCategory = null
    const [selectedCategory, setSelectedCategory] = useState(initialCategory)

    const handleCategorySelect = (category) => {
        setSelectedCategory(prev => prev === category ? initialCategory : category);
    };

    const resetFilters = () => {
        setSelectedCategory(initialCategory);
    };

    return {
        selectedCategory,
        handleCategorySelect,
        resetFilters
    };
}
