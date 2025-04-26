import { useEffect } from 'react';
import { shallowEqual, useDispatch, useSelector } from 'react-redux';
import { fetchPage } from '../redux/pageSlice';

export default function usePage(pageType) {
    const dispatch = useDispatch();
    
    const { data, loading, error } = useSelector(state => {
        const pageData = state.page.pages[pageType];
        return {
            data: pageData?.data || null,
            loading: pageData?.loading || false,
            error: pageData?.error || null
        };
    }, shallowEqual)

    useEffect(() => {
        if (!data && !loading) {
            dispatch(fetchPage(pageType));
        }
    }, [dispatch, pageType, data, loading]);

    return {
        data,
        loading,
        error,
        refetch: () => dispatch(fetchPage(pageType))
    };
}