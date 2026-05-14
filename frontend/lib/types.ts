export type Product = {
  id: string;
  title: string;
  image: string;
  price: number;
  originalPrice?: number;
  discount?: number; // percent
  rating: number; // 0..5
  sold: number;
  shipping: string;
  freeShipping?: boolean;
  badge?: string;
  category?: string;
  categoryName?: string;
};

export type CategoryGroup = {
  title: string;
  links: string[];
};

export type CategoryFeature = {
  title: string;
  image: string;
  href?: string;
};

export type Category = {
  slug: string;
  name: string;
  icon?: string;
  image?: string;
  groups?: CategoryGroup[];
  featured?: CategoryFeature[];
};

export type PromoTile = {
  title: string;
  subtitle?: string;
  image: string;
  cta?: string;
  href?: string;
  bg?: string;
};

export type Currency = {
  code: string;
  name?: string;
  symbol?: string | null;
  exchange_rate?: number | string;
  is_default?: boolean;
  is_active?: boolean;
};
