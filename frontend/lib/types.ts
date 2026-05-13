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
};

export type Category = {
  slug: string;
  name: string;
  icon?: string;
  image?: string;
};

export type PromoTile = {
  title: string;
  subtitle?: string;
  image: string;
  cta?: string;
  href?: string;
  bg?: string;
};
