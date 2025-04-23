import { useEffect, useState, useMemo } from 'react';

export default function useProductFilter(productData) {
    const [selectedColor, setSelectedColor] = useState(null);
    const [selectedSize, setSelectedSize] = useState(null);
    const [availableSizes, setAvailableSizes] = useState([]);

    // Tüm renk ve bedenleri çıkar
    const { colors, allSizes } = useMemo(() => {
        const colors = new Map();
        const sizes = new Map();

        if (productData?.variants) {
            productData.variants.forEach(variant => {
                variant.attributes.forEach(attr => {
                    if (attr.attribute.slug === 'color') {
                        colors.set(attr.slug, {
                            name: attr.value,
                            slug: attr.slug,
                            icon: attr.icon
                        });
                    } else if (attr.attribute.slug === 'size') {
                        sizes.set(attr.slug, {
                            name: attr.value,
                            slug: attr.slug,
                            icon: attr.icon
                        });
                    }
                });
            });
        }

        return {
            colors: Array.from(colors.values()),
            allSizes: Array.from(sizes.values())
        };
    }, [productData]);

    // Renk değiştiğinde uygun bedenleri güncelle ve İLK BEDENİ SEÇ
    useEffect(() => {
        if (!productData?.variants || !selectedColor) {
            setAvailableSizes(allSizes);
            return;
        }

        const sizeSet = new Set();
        productData.variants.forEach(variant => {
            // Seçilen renge sahip varyantları bul
            const hasColor = variant.attributes.some(
                attr => attr.attribute.slug === 'color' && attr.slug === selectedColor
            );
            
            if (hasColor) {
                variant.attributes.forEach(attr => {
                    if (attr.attribute.slug === 'size') {
                        sizeSet.add(attr.slug);
                    }
                });
            }
        });

        const filteredSizes = allSizes.filter(size => sizeSet.has(size.slug));
        setAvailableSizes(filteredSizes);

        // O renge ait ilk bedeni otomatik seç (eğer varsa ve zaten seçili değilse)
        if (filteredSizes.length > 0 && !filteredSizes.some(size => size.slug === selectedSize)) {
            setSelectedSize(filteredSizes[0].slug);
        }
    }, [selectedColor, productData, allSizes]);

    // Başlangıçta varsayılan değerleri ayarla
    useEffect(() => {
        if (!productData?.variants?.length) return;

        // İlk rengi seç
        if (colors.length > 0 && !selectedColor) {
            setSelectedColor(colors[0].slug);
        }
    }, [productData, colors]);

    // Mevcut varyantı bul
    const currentVariant = useMemo(() => {
        if (!productData?.variants) return null;
        
        return productData.variants.find(variant => {
            return variant.attributes.every(attr => {
                if (attr.attribute.slug === 'color') {
                    return selectedColor === attr.slug;
                }
                if (attr.attribute.slug === 'size') {
                    return selectedSize === attr.slug;
                }
                return true;
            });
        });
    }, [productData, selectedColor, selectedSize]);

    const handleColorSelect = (colorSlug) => {
        setSelectedColor(colorSlug);
        // Size'ı sıfırlama, yukarıdaki useEffect otomatik ayarlayacak
    };

    const handleSizeSelect = (sizeSlug) => {
        setSelectedSize(sizeSlug);
    };

    // Ürün verisini hazırla
    const productDisplay = useMemo(() => {
        if (!productData) return null;
        
        const baseData = {
            productId: productData.id,
            slug: productData.slug,
            title: productData.title,
            cover: productData.cover,
            desc: productData.desc,
            short_desc: productData.short_desc,
            variants: productData.variants,
            gender: productData.gender,
            is_new: productData.is_new,
            is_featured: productData.is_featured,
            is_best_seller: productData.is_best_seller,
        };

        return currentVariant ? {
            ...baseData,
            variantId: currentVariant.id,
            slug: productData.slug,
            price: currentVariant.offer_price ?? currentVariant.price,
            price_html: currentVariant.price_html,
            stock: currentVariant.stock,
            thumbnail: currentVariant.thumbnail ?? productData.thumbnail,
            galleries: currentVariant.galleries,
            category: currentVariant.category ?? productData.category,
        } : {
            ...baseData,
            variantId: null,
            price: productData.offer_price ?? productData.price,
            price_html: productData.price_html,
            stock: productData.stock,
            thumbnail: productData.thumbnail,
            galleries: productData.galleries,
            category: productData.category,
        };
    }, [productData, currentVariant]);

    return {
        selectedColor,
        selectedSize,
        colors,
        sizes: availableSizes,
        handleColorSelect,
        handleSizeSelect,
        currentVariant,
        productDisplay,
    };
}