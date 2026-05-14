import type { Product, Category, PromoTile } from "./types";

const img = (seed: string, w = 600, h = 600) =>
  `https://picsum.photos/seed/${encodeURIComponent(seed)}/${w}/${h}`;

export const categories: Category[] = [
  {
    slug: "womens-fashion", name: "Women's Fashion", image: img("womens", 200, 200),
    groups: [
      { title: "Clothing", links: ["Dresses", "Tops & Tees", "Hoodies & Sweatshirts", "Jeans", "Skirts", "Pants & Leggings", "Suits & Sets", "Sweaters", "Activewear", "Plus Size"] },
      { title: "Outerwear", links: ["Coats", "Jackets", "Trench Coats", "Blazers", "Vests", "Faux Fur"] },
      { title: "Underwear & Sleep", links: ["Bras", "Panties", "Shapewear", "Pajamas", "Lingerie Sets", "Robes"] },
      { title: "Wedding & Events", links: ["Bridal", "Bridesmaid", "Cocktail", "Prom", "Mother of Bride"] },
      { title: "Accessories", links: ["Scarves", "Hats", "Belts", "Gloves", "Hair Accessories"] }
    ],
    featured: [
      { title: "Summer Dresses · -50%", image: img("women-feat-1", 280, 180) },
      { title: "New: Plus Size", image: img("women-feat-2", 280, 180) }
    ]
  },
  {
    slug: "mens-fashion", name: "Men's Fashion", image: img("mens", 200, 200),
    groups: [
      { title: "Clothing", links: ["T-Shirts", "Polo Shirts", "Shirts", "Hoodies", "Jeans", "Pants", "Shorts", "Suits", "Activewear", "Plus Size"] },
      { title: "Outerwear", links: ["Jackets", "Coats", "Bomber Jackets", "Parkas", "Vests"] },
      { title: "Underwear & Sleep", links: ["Boxers", "Briefs", "Undershirts", "Pajamas", "Robes"] },
      { title: "Accessories", links: ["Belts", "Hats", "Sunglasses", "Ties & Bowties", "Wallets"] }
    ],
    featured: [
      { title: "Trending Sneakers", image: img("men-feat-1", 280, 180) },
      { title: "Big & Tall Fit", image: img("men-feat-2", 280, 180) }
    ]
  },
  {
    slug: "phones-telecom", name: "Phones & Telecom", image: img("phones", 200, 200),
    groups: [
      { title: "Smartphones", links: ["iPhone", "Samsung", "Xiaomi", "OnePlus", "Google Pixel", "Refurbished", "Unlocked", "5G Phones"] },
      { title: "Accessories", links: ["Cases & Covers", "Screen Protectors", "Chargers", "Power Banks", "Cables", "Wireless Chargers", "Holders & Stands"] },
      { title: "Audio", links: ["Earphones", "Bluetooth Earbuds", "Headphones", "Speakers", "Car Audio"] },
      { title: "Smart Devices", links: ["Smart Watches", "Fitness Trackers", "VR Headsets"] }
    ],
    featured: [
      { title: "Latest Flagships", image: img("phone-feat-1", 280, 180) },
      { title: "Earbuds Sale", image: img("phone-feat-2", 280, 180) }
    ]
  },
  {
    slug: "computer-office", name: "Computer & Office", image: img("computers", 200, 200),
    groups: [
      { title: "Laptops & Desktops", links: ["Gaming Laptops", "Business Laptops", "MacBooks", "Chromebooks", "Desktop PCs", "Mini PCs", "All-in-Ones"] },
      { title: "Components", links: ["GPUs", "CPUs", "Motherboards", "RAM", "Storage", "Power Supplies", "Cases", "Cooling"] },
      { title: "Peripherals", links: ["Keyboards", "Mice", "Monitors", "Webcams", "Printers", "Scanners"] },
      { title: "Networking", links: ["Routers", "WiFi Extenders", "Switches", "Network Cards"] },
      { title: "Office", links: ["Stationery", "Office Chairs", "Desks", "Storage & Organization"] }
    ],
    featured: [
      { title: "RTX Gaming GPUs", image: img("comp-feat-1", 280, 180) },
      { title: "Ergo Chair Deal", image: img("comp-feat-2", 280, 180) }
    ]
  },
  {
    slug: "consumer-electronics", name: "Consumer Electronics", image: img("electronics", 200, 200),
    groups: [
      { title: "TV & Video", links: ["Smart TVs", "4K TVs", "Projectors", "Streaming Devices", "TV Mounts"] },
      { title: "Cameras", links: ["DSLRs", "Mirrorless", "Action Cameras", "Drones", "Lenses", "Tripods"] },
      { title: "Audio", links: ["Hi-Fi Systems", "Soundbars", "Vinyl Players", "Microphones"] },
      { title: "Gaming", links: ["Consoles", "Controllers", "Games", "VR Gaming"] }
    ],
    featured: [
      { title: "Mini Projector -60%", image: img("ce-feat-1", 280, 180) },
      { title: "4K Action Cam", image: img("ce-feat-2", 280, 180) }
    ]
  },
  {
    slug: "jewelry-watches", name: "Jewelry & Watches", image: img("jewelry", 200, 200),
    groups: [
      { title: "Watches", links: ["Men's Watches", "Women's Watches", "Smart Watches", "Luxury", "Sport Watches", "Couple Watches"] },
      { title: "Fine Jewelry", links: ["Necklaces", "Earrings", "Rings", "Bracelets", "Brooches", "Anklets"] },
      { title: "Wedding", links: ["Engagement Rings", "Wedding Bands", "Bridal Sets"] },
      { title: "Materials", links: ["Sterling Silver", "Gold-Plated", "Stainless Steel", "Pearl", "Crystal"] }
    ],
    featured: [
      { title: "Silver Pendants -40%", image: img("jewel-feat-1", 280, 180) },
      { title: "Smart Watch Pro", image: img("jewel-feat-2", 280, 180) }
    ]
  },
  {
    slug: "home-garden", name: "Home & Garden", image: img("home", 200, 200),
    groups: [
      { title: "Kitchen & Dining", links: ["Cookware", "Knives", "Bakeware", "Dinnerware", "Storage", "Small Appliances", "Coffee & Tea"] },
      { title: "Bedding & Bath", links: ["Sheets", "Comforters", "Pillows", "Towels", "Curtains", "Rugs"] },
      { title: "Home Decor", links: ["Wall Art", "Vases", "Candles", "Clocks", "Mirrors", "Plants"] },
      { title: "Lighting", links: ["LED Bulbs", "Lamps", "Ceiling Lights", "LED Strips", "Outdoor Lighting"] },
      { title: "Garden", links: ["Planters", "Seeds", "Outdoor Furniture", "BBQ & Grilling"] }
    ],
    featured: [
      { title: "Smart Home Deals", image: img("home-feat-1", 280, 180) },
      { title: "LED Strip -55%", image: img("home-feat-2", 280, 180) }
    ]
  },
  {
    slug: "bags-shoes", name: "Bags & Shoes", image: img("bags", 200, 200),
    groups: [
      { title: "Women's Shoes", links: ["Heels", "Flats", "Boots", "Sneakers", "Sandals", "Wedges"] },
      { title: "Men's Shoes", links: ["Sneakers", "Boots", "Loafers", "Oxfords", "Sandals", "Athletic"] },
      { title: "Bags", links: ["Handbags", "Backpacks", "Crossbody", "Tote Bags", "Wallets", "Luggage"] },
      { title: "Athletic", links: ["Running Shoes", "Training Shoes", "Hiking Boots", "Trail Runners"] }
    ],
    featured: [
      { title: "Sneaker Drop", image: img("bags-feat-1", 280, 180) },
      { title: "Backpack Sale", image: img("bags-feat-2", 280, 180) }
    ]
  },
  {
    slug: "mother-kids", name: "Mother & Kids", image: img("kids", 200, 200),
    groups: [
      { title: "Baby & Toddler", links: ["Clothing", "Diapers", "Feeding", "Baby Care", "Strollers", "Car Seats"] },
      { title: "Toys", links: ["Educational", "Building Blocks", "Dolls", "Action Figures", "Outdoor Toys"] },
      { title: "Kids' Clothing", links: ["Girls' Tops", "Girls' Dresses", "Boys' Tops", "Boys' Pants", "Shoes"] },
      { title: "Maternity", links: ["Maternity Wear", "Nursing", "Pregnancy Care"] }
    ],
    featured: [
      { title: "Baby Essentials", image: img("kids-feat-1", 280, 180) },
      { title: "STEM Toys", image: img("kids-feat-2", 280, 180) }
    ]
  },
  {
    slug: "sports-outdoor", name: "Sports & Outdoor", image: img("sports", 200, 200),
    groups: [
      { title: "Fitness", links: ["Yoga Mats", "Dumbbells", "Resistance Bands", "Treadmills", "Exercise Bikes"] },
      { title: "Outdoor", links: ["Camping", "Hiking", "Cycling", "Climbing", "Water Sports"] },
      { title: "Team Sports", links: ["Soccer", "Basketball", "Baseball", "Tennis", "Golf"] },
      { title: "Apparel", links: ["Men's Activewear", "Women's Activewear", "Athletic Shoes", "Compression"] }
    ],
    featured: [
      { title: "Yoga Bundle", image: img("sport-feat-1", 280, 180) },
      { title: "Camping Gear", image: img("sport-feat-2", 280, 180) }
    ]
  },
  {
    slug: "beauty-health", name: "Beauty, Health & Hair", image: img("beauty", 200, 200),
    groups: [
      { title: "Skincare", links: ["Moisturizers", "Serums", "Cleansers", "Sunscreen", "Masks", "Anti-Aging"] },
      { title: "Makeup", links: ["Lipstick", "Foundation", "Eyeshadow", "Mascara", "Brushes", "Setting Sprays"] },
      { title: "Hair", links: ["Wigs", "Hair Extensions", "Hair Care", "Styling Tools", "Hair Color"] },
      { title: "Health", links: ["Vitamins", "Personal Care", "Massage", "Medical Supplies"] }
    ],
    featured: [
      { title: "K-Beauty Drop", image: img("beauty-feat-1", 280, 180) },
      { title: "Wig Sale -45%", image: img("beauty-feat-2", 280, 180) }
    ]
  },
  {
    slug: "automotive", name: "Automotive & Motorcycle", image: img("auto", 200, 200),
    groups: [
      { title: "Car Electronics", links: ["Dash Cams", "Car Stereo", "GPS", "Backup Cameras", "Bluetooth"] },
      { title: "Interior", links: ["Seat Covers", "Floor Mats", "Steering Covers", "Air Fresheners"] },
      { title: "Exterior", links: ["Lights", "Mirrors", "Body Kits", "Cleaning"] },
      { title: "Motorcycle", links: ["Helmets", "Riding Gear", "Bike Accessories", "Parts"] }
    ],
    featured: [
      { title: "Dash Cam HD", image: img("auto-feat-1", 280, 180) },
      { title: "Helmet Sale", image: img("auto-feat-2", 280, 180) }
    ]
  },
  {
    slug: "tools", name: "Tools & Home Improvement", image: img("tools", 200, 200),
    groups: [
      { title: "Power Tools", links: ["Drills", "Saws", "Sanders", "Grinders", "Tool Sets"] },
      { title: "Hand Tools", links: ["Wrenches", "Screwdrivers", "Pliers", "Hammers", "Measuring"] },
      { title: "Electrical", links: ["Wire & Cable", "Switches", "Outlets", "Lighting Fixtures"] },
      { title: "Plumbing", links: ["Fittings", "Faucets", "Pipes", "Valves"] }
    ],
    featured: [
      { title: "Drill Kit -30%", image: img("tool-feat-1", 280, 180) },
      { title: "Smart Locks", image: img("tool-feat-2", 280, 180) }
    ]
  },
  {
    slug: "toys-hobbies", name: "Toys, Kids & Babies", image: img("toys", 200, 200),
    groups: [
      { title: "Hobbies", links: ["Models", "RC Vehicles", "Drones", "Board Games", "Puzzles"] },
      { title: "Outdoor Play", links: ["Trampolines", "Pools", "Bikes & Scooters", "Slides"] },
      { title: "Educational", links: ["STEM Kits", "Books", "Microscopes", "Globes"] },
      { title: "Collectibles", links: ["Action Figures", "Trading Cards", "Plush", "Funko"] }
    ],
    featured: [
      { title: "RC Drone Pro", image: img("toy-feat-1", 280, 180) },
      { title: "Building Sets", image: img("toy-feat-2", 280, 180) }
    ]
  }
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
