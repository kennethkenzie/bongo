import type { Product, Category, PromoTile } from "./types";

const img = (seed: string, w = 600, h = 600) =>
  `https://picsum.photos/seed/${encodeURIComponent(seed)}/${w}/${h}`;

export const categories: Category[] = [
  { slug: "womens-fashion", name: "Women's Fashion", image: img("womens", 200, 200) },
  { slug: "mens-fashion", name: "Men's Fashion", image: img("mens", 200, 200) },
  { slug: "phones-telecom", name: "Phones & Telecom", image: img("phones", 200, 200) },
  { slug: "computer-office", name: "Computer & Office", image: img("computers", 200, 200) },
  { slug: "consumer-electronics", name: "Consumer Electronics", image: img("electronics", 200, 200) },
  { slug: "jewelry-watches", name: "Jewelry & Watches", image: img("jewelry", 200, 200) },
  { slug: "home-garden", name: "Home & Garden", image: img("home", 200, 200) },
  { slug: "bags-shoes", name: "Bags & Shoes", image: img("bags", 200, 200) },
  { slug: "mother-kids", name: "Mother & Kids", image: img("kids", 200, 200) },
  { slug: "sports-outdoor", name: "Sports & Outdoor", image: img("sports", 200, 200) },
  { slug: "beauty-health", name: "Beauty, Health & Hair", image: img("beauty", 200, 200) },
  { slug: "automotive", name: "Automotive & Motorcycle", image: img("auto", 200, 200) },
  { slug: "tools", name: "Tools & Home Improvement", image: img("tools", 200, 200) },
  { slug: "toys-hobbies", name: "Toys, Kids & Babies", image: img("toys", 200, 200) }
];

const titles = [
  "Wireless Bluetooth Earbuds Pro Noise Cancelling",
  "Women's Casual Summer Dress Floral Print",
  "Smart Watch HD Touch Screen Heart Rate Monitor",
  "Men's Slim Fit Cotton Button-Down Shirt",
  "Portable Mini Projector 1080P HD Home Theater",
  "Stainless Steel Kitchen Knife Set 6-Piece",
  "LED Strip Lights RGB 16.4ft Color Changing",
  "Anti-Blue Light Computer Glasses Unisex",
  "Foldable Travel Backpack 40L Water Resistant",
  "Wireless Charging Pad Fast Charge Qi 15W",
  "Robot Vacuum Cleaner Smart Mapping Auto Charge",
  "Yoga Mat Non-Slip 6mm Thick Eco-Friendly",
  "Mechanical Gaming Keyboard RGB Backlit",
  "Air Fryer Digital 5.8 Quart Oilless Cooker",
  "Sterling Silver Pendant Necklace for Women",
  "Men's Leather Wallet Bifold RFID Blocking",
  "Electric Toothbrush Sonic Rechargeable",
  "Memory Foam Pillow Cervical Contour",
  "Car Phone Holder Magnetic Dashboard Mount",
  "Resistance Bands Set 5-Piece Workout Loop",
  "Coffee Grinder Electric Burr Adjustable",
  "Pet Cat Tree Tower with Scratching Post",
  "Drone with 4K Camera GPS Auto Return",
  "Sunglasses Polarized UV400 Unisex Aviator"
];

function mkProduct(i: number): Product {
  const t = titles[i % titles.length];
  const seed = `prod-${i}-${t.split(" ")[0]}`;
  const original = 9.99 + ((i * 7.31) % 200);
  const discount = 10 + ((i * 13) % 70);
  const price = +(original * (1 - discount / 100)).toFixed(2);
  return {
    id: `p${i + 1}`,
    title: t,
    image: img(seed),
    price,
    originalPrice: +original.toFixed(2),
    discount,
    rating: +(3.6 + ((i * 0.17) % 1.4)).toFixed(1),
    sold: 50 + ((i * 173) % 12000),
    shipping: i % 3 === 0 ? "Free shipping" : i % 3 === 1 ? "$1.99 shipping" : "Free shipping to US",
    freeShipping: i % 3 !== 1,
    badge: i % 5 === 0 ? "Choice" : i % 7 === 0 ? "Bestseller" : i % 9 === 0 ? "New" : undefined,
    category: categories[i % categories.length].slug
  };
}

export const flashDeals: Product[] = Array.from({ length: 10 }, (_, i) => mkProduct(i + 100));
export const recommended: Product[] = Array.from({ length: 12 }, (_, i) => mkProduct(i + 200));
export const trending: Product[] = Array.from({ length: 10 }, (_, i) => mkProduct(i + 300));
export const moreToLove: Product[] = Array.from({ length: 24 }, (_, i) => mkProduct(i + 400));

export const heroSlides: PromoTile[] = [
  {
    title: "Mega Sale",
    subtitle: "Up to 70% off across the marketplace",
    image: img("hero-mega", 1400, 520),
    cta: "Shop now",
    bg: "from-brand-700 to-brand-500"
  },
  {
    title: "New Arrivals",
    subtitle: "Discover what's trending this week",
    image: img("hero-new", 1400, 520),
    cta: "Explore",
    bg: "from-brand-600 to-brand-400"
  },
  {
    title: "Free Shipping",
    subtitle: "On thousands of items worldwide",
    image: img("hero-ship", 1400, 520),
    cta: "Learn more",
    bg: "from-brand-800 to-brand-600"
  }
];

export const promoTiles: PromoTile[] = [
  { title: "Welcome deal", subtitle: "Up to 50% off", image: img("promo-welcome", 400, 240), cta: "Get it" },
  { title: "Coins for everyone", subtitle: "Earn & save", image: img("promo-coins", 400, 240), cta: "Collect" },
  { title: "Top brands", subtitle: "Up to 80% off", image: img("promo-brands", 400, 240), cta: "Shop" },
  { title: "Big Save", subtitle: "Daily deals", image: img("promo-bigsave", 400, 240), cta: "Save now" }
];

export const topCategoryShortcuts: Category[] = categories.slice(0, 12);
