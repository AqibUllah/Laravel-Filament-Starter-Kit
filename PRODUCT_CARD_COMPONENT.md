# Product Card Component Usage

The `product-card.blade.php` component has been created to eliminate duplicate product card code across the marketplace views.

## Component Features

### Props
- `product` (required) - The product model to display
- `variant` (optional, default: 'standard') - Card style: 'standard', 'featured', or 'minimal'
- `showQuickView` (optional, default: false) - Show quick view overlay
- `showRating` (optional, default: false) - Show product rating
- `showWishlist` (optional, default: true) - Show wishlist button
- `showSellerBadge` (optional, default: true) - Show seller/team badge
- `showFeaturedBadge` (optional, default: true) - Show featured badge
- `buttonText` (optional, auto-generated) - Custom button text
- `buttonAction` (optional, default: 'cart') - Button action: 'cart', 'details', or 'view'

### Variants

#### Standard Variant
- Used in main product grids
- Shows seller badge, wishlist button
- Dual action buttons (Details + Add to Cart)
- 56px image height

```blade
<x-product-card :product="$product" variant="standard" />
```

#### Featured Variant
- Used for featured products section
- Shows seller badge, featured badge, rating
- Quick view overlay on hover
- Single Add to Cart button with gradient
- 64px image height

```blade
<x-product-card :product="$product" variant="featured" :show-quick-view="true" :show-rating="true" :show-wishlist="false" />
```

#### Minimal Variant
- Used for related products
- No badges or wishlist
- No description text
- Centered price
- Single View Product button

```blade
<x-product-card :product="$product" variant="minimal" :show-wishlist="false" button-action="view" button-text="View Product" />
```

## Usage Examples

### Basic Usage
```blade
<x-product-card :product="$product" />
```

### Custom Button Action
```blade
<x-product-card :product="$product" button-action="details" button-text="View Details" />
```

### Hide Elements
```blade
<x-product-card :product="$product" :show-wishlist="false" :show-seller-badge="false" />
```

## Benefits

1. **DRY Principle**: Eliminates duplicate code across views
2. **Consistency**: Ensures uniform product card styling
3. **Maintainability**: Single source of truth for product card design
4. **Flexibility**: Multiple variants and customization options
5. **Reusability**: Can be used in any future marketplace-related views

## Files Modified

- `resources/views/components/product-card.blade.php` (NEW)
- `resources/views/marketplace/index.blade.php` (UPDATED)
- `resources/views/marketplace/show.blade.php` (UPDATED)

The component maintains all original functionality while providing a clean, reusable interface for displaying products across the marketplace.
