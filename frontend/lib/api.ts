import * as mock from "./data";
import type { Product, Category, Currency } from "./types";

const API = process.env.NEXT_PUBLIC_API_URL || "http://localhost:8000/api/v1";
const USE_MOCK = (process.env.NEXT_PUBLIC_USE_MOCK ?? "true") === "true";

async function safe<T>(url: string, fallback: T): Promise<T> {
  if (USE_MOCK) return fallback;
  try {
    const res = await fetch(url, { cache: "no-store" });
    if (!res.ok) throw new Error(`HTTP ${res.status}`);
    return (await res.json()) as T;
  } catch (e) {
    if (process.env.NODE_ENV !== "production") {
      console.warn(`[api] ${url} failed, using mock:`, e);
    }
    return fallback;
  }
}


function apiOrigin() {
  try {
    return new URL(API).origin;
  } catch {
    return "http://localhost:8000";
  }
}

function normalizeAssetUrl(url?: string | null): string {
  if (!url) return "";
  if (/^https?:\/\//i.test(url)) return url;
  if (url.startsWith("/storage/") || url.startsWith("/uploads/")) {
    return `${apiOrigin()}${url}`;
  }
  return url;
}

type ApiProduct = Omit<Product, "id" | "price" | "rating" | "category"> & {
  id: string | number;
  price: string | number;
  rating: string | number;
  original_price?: string | number | null;
  free_shipping?: boolean | null;
  category?: string | Category | null;
};

function normalizeProduct(product: ApiProduct): Product {
  const originalPrice = product.originalPrice ?? product.original_price;
  const apiCategory = product.category;
  const category = typeof apiCategory === "object" && apiCategory !== null ? apiCategory.slug : apiCategory;
  const categoryName = typeof apiCategory === "object" && apiCategory !== null ? apiCategory.name : undefined;

  return {
    ...product,
    id: String(product.id),
    image: normalizeAssetUrl(product.image),
    price: Number(product.price),
    originalPrice: originalPrice == null ? undefined : Number(originalPrice),
    rating: Number(product.rating),
    freeShipping: product.freeShipping ?? product.free_shipping ?? false,
    category: category ?? undefined,
    categoryName,
  };
}

function normalizeProducts(products: ApiProduct[] = []): Product[] {
  return products.map(normalizeProduct);
}

export const api = {
  currency: () =>
    safe<Currency>(`${API}/settings/currency`, { code: "USD", name: "US Dollar", symbol: "$", exchange_rate: 1, is_default: true, is_active: true }),

  home: () =>
    safe<{
      categories: Category[];
      flash_deals: ApiProduct[];
      recommended: ApiProduct[];
      trending: ApiProduct[];
      more_to_love: ApiProduct[];
    }>(`${API}/home`, {
      categories: mock.categories,
      flash_deals: mock.flashDeals,
      recommended: mock.recommended,
      trending: mock.trending,
      more_to_love: mock.moreToLove,
    }).then((data) => ({
      ...data,
      flash_deals: normalizeProducts(data.flash_deals),
      recommended: normalizeProducts(data.recommended),
      trending: normalizeProducts(data.trending),
      more_to_love: normalizeProducts(data.more_to_love),
    })),

  categories: () => safe<Category[]>(`${API}/categories`, mock.categories),

  category: (slug: string) =>
    safe<{ category: Category; products: { data: ApiProduct[] } }>(
      `${API}/categories/${slug}`,
      {
        category: mock.categories.find((c) => c.slug === slug) ?? mock.categories[0],
        products: { data: mock.moreToLove },
      }
    ).then((data) => ({
      ...data,
      products: {
        ...data.products,
        data: normalizeProducts(data.products.data),
      },
    })),

  product: (id: string) => {
    const ALL = [...mock.flashDeals, ...mock.recommended, ...mock.moreToLove, ...mock.trending];
    return safe<ApiProduct>(`${API}/products/${id}`, ALL.find((p) => p.id === id) ?? ALL[0]).then(normalizeProduct);
  },

  search: (q: string) =>
    safe<{ data: ApiProduct[] }>(`${API}/products/search?q=${encodeURIComponent(q)}`, {
      data: mock.moreToLove.filter((p) => p.title.toLowerCase().includes(q.toLowerCase())),
    }).then((data) => ({
      ...data,
      data: normalizeProducts(data.data),
    })),
};
