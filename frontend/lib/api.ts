import * as mock from "./data";
import type { Product, Category } from "./types";

const API = process.env.NEXT_PUBLIC_API_URL || "http://localhost:8000/api/v1";
const USE_MOCK = (process.env.NEXT_PUBLIC_USE_MOCK ?? "true") === "true";

async function safe<T>(url: string, fallback: T): Promise<T> {
  if (USE_MOCK) return fallback;
  try {
    const res = await fetch(url, { next: { revalidate: 60 } });
    if (!res.ok) throw new Error(`HTTP ${res.status}`);
    return (await res.json()) as T;
  } catch (e) {
    if (process.env.NODE_ENV !== "production") {
      console.warn(`[api] ${url} failed, using mock:`, e);
    }
    return fallback;
  }
}

export const api = {
  home: () =>
    safe<{
      categories: Category[];
      flash_deals: Product[];
      recommended: Product[];
      trending: Product[];
      more_to_love: Product[];
    }>(`${API}/home`, {
      categories: mock.categories,
      flash_deals: mock.flashDeals,
      recommended: mock.recommended,
      trending: mock.trending,
      more_to_love: mock.moreToLove,
    }),

  categories: () => safe<Category[]>(`${API}/categories`, mock.categories),

  category: (slug: string) =>
    safe<{ category: Category; products: { data: Product[] } }>(
      `${API}/categories/${slug}`,
      {
        category: mock.categories.find((c) => c.slug === slug) ?? mock.categories[0],
        products: { data: mock.moreToLove },
      }
    ),

  product: (id: string) => {
    const ALL = [...mock.flashDeals, ...mock.recommended, ...mock.moreToLove, ...mock.trending];
    return safe<Product>(`${API}/products/${id}`, ALL.find((p) => p.id === id) ?? ALL[0]);
  },

  search: (q: string) =>
    safe<{ data: Product[] }>(`${API}/products/search?q=${encodeURIComponent(q)}`, {
      data: mock.moreToLove.filter((p) => p.title.toLowerCase().includes(q.toLowerCase())),
    }),
};
