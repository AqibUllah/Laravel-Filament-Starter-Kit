# Category Card Component Usage

The `category-card.blade.php` component has been created to provide a reusable category card design for the marketplace.

## Component Features

### Props
- `category` (required) - The category model to display
- `variant` (optional, default: 'standard') - Card style: 'standard' or 'compact'
- `showProductCount` (optional, default: true) - Show/hide product count
- `icon` (optional, default: null) - Custom SVG icon HTML or null for default icon

### Variants

#### Standard Variant
- Default category card style
- 20x20 icon container
- p-8 padding
- Extra large title (text-xl)
- Used in main category grid

```blade
<x-category-card :category="$category" />
```

#### Compact Variant
- Smaller category card style
- 16x16 icon container
- p-6 padding
- Large title (text-lg)
- Suitable for sidebar or tighter spaces

```blade
<x-category-card :category="$category" variant="compact" />
```

## Usage Examples

### Basic Usage
```blade
<x-category-card :category="$category" />
```

### Compact Variant
```blade
<x-category-card :category="$category" variant="compact" />
```

### Hide Product Count
```blade
<x-category-card :category="$category" :show-product-count="false" />
```

### Custom Icon
```blade
<x-category-card :category="$category" :icon="'<svg>...</svg>'" />
```

### Custom Icon with Compact Variant
```blade
<x-category-card :category="$category" variant="compact" :show-product-count="false" :icon="'<svg class=\"w-8 h-8 text-white\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z\"/></svg>'" />
```

## Design Features

### Interactive Elements
- **Hover Effect**: Card lifts up with enhanced shadow
- **Icon Rotation**: Icon rotates 6 degrees on hover
- **Background Pattern**: Subtle animated pattern appears on hover
- **Progress Bar**: Bottom border animates from left to right on hover
- **Smooth Transitions**: All animations use 500ms duration

### Visual Design
- **Gradient Background**: White to light gray gradient
- **Rounded Corners**: 2xl border radius for modern look
- **Icon Container**: Blue to indigo gradient with rounded corners
- **Typography**: Bold category name with product count
- **Responsive Grid**: Works with 2-4 column layouts

### Default Icon
The component uses a default category icon (box/package) when no custom icon is provided:
```svg
<svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012-2 2 2 2 2 0 012 2-2 2zm-7 4h1a1 1 0 110-1v-4a1 1 0 00-1-1h-3a1 1 0 00-1 1v4a1 1 0 001 1h3a1 1 0 001 1z"/>
</svg>
```

## Category Model Requirements

The category model should have the following properties:
- `id` - Category ID for routing
- `name` - Category name for display
- `public_products_count` - Count of public products (optional, used when showProductCount is true)

## Routing

The component automatically links to the marketplace index with the category filter:
```php
route('marketplace.index', ['category' => $category->id])
```

## Benefits

1. **DRY Principle**: Eliminates duplicate category card code
2. **Consistency**: Ensures uniform category card styling
3. **Maintainability**: Single source of truth for category card design
4. **Flexibility**: Multiple variants and customization options
5. **Reusability**: Can be used in any future category-related views
6. **Responsive**: Adapts to different grid layouts
7. **Accessible**: Proper semantic HTML structure

## Files Modified

- `resources/views/components/category-card.blade.php` (NEW)
- `resources/views/marketplace/index.blade.php` (UPDATED)

The component maintains all original functionality including hover effects, animations, and responsive design while providing a clean, reusable interface for displaying categories throughout the marketplace.
