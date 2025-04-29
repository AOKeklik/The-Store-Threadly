export const arangedData = (filteredData) => filteredData.flatMap(product => {
    // Eğer varyant varsa, sadece ilk varyantı döndür
    if (product.variants?.length > 0) {

        /* Varsa indirimli, yoksa ilk variant */
        const variant = product.variants.find(v => v.offer_price) || product.variants[0]

        const attributes = variant.attributes?.reduce((acc, attr) => {
            if (attr.attribute.slug === "color") {
                acc.color = {
                    value: attr.value,
                    icon: attr.icon,
                    slug: attr.slug,
                }
            } else if (attr.attribute.slug === "size") {
                acc.size = {
                    value: attr.value,
                    icon: attr.icon,
                    slug: attr.slug,
                }
            }
            return acc
        }, { color: null, size: null })

        return [{
            productId: product.id,     
            variantId: variant.id,
            isVariant: true,
            slug: product.slug,
            title: product.title,
            short_desc: product.short_desc,
            price: variant.offer_price ? variant.offer_price : variant.price,
            base_price: variant.price,
            offer_price: variant.offer_price,
            price_html: variant.price_html,
            stock: variant.stock,
            thumbnail: variant.thumbnail,
            cover: product.cover,
            galeries: variant.galeries?.length > 0 ? variant.galeries : product.galeries,
            category: {
                name: product.category?.name,
                slug: product.category?.slug,
            },
            color: attributes.color,
            size: attributes.size,
            gender: product.gender,
            is_new: product.is_new,
            is_featured: product.is_featured,
            is_best_seller: product.is_best_seller, 
        }];
    }

    // Varyant yoksa ürünün kendisini döndür
    return [{
        productId: product.id,     
        variantId: null,
        isVariant: false,
        slug: product.slug,
        title: product.title,
        short_desc: product.short_desc,
        price: product.offer_price ? product.offer_price : product.price,
        offer_price: product.offer_price,
        price_html: product.price_html,
        stock: product.stock,
        thumbnail: product.thumbnail,
        cover: product.cover,
        galeries: product.galeries,
        category: {
            name: product.category?.name,
            slug: product.category?.slug,
        },
        color: null,
        size: null,
        gender: product.gender,
        is_new: product.is_new,
        is_featured: product.is_featured,
        is_best_seller: product.is_best_seller,         
    }];
}) || []