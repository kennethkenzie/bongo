import Link from "next/link";
import type { Category } from "@/lib/types";
import { ChevronDown, Tag } from "lucide-react";

const featured = [
  "SuperDeals",
  "Free Shipping",
  "Bongo Mall",
  "New Arrivals",
  "Best Sellers",
  "Coupons",
  "Top Brands",
  "Help Center"
];

export default function CategoryNav({ categories }: { categories: Category[] }) {
  return (
    <nav className="bg-white border-b border-line">
      <div className="container-x flex items-center gap-6 h-10 overflow-x-auto hide-scrollbar text-sm">
        <button className="flex items-center gap-2 text-brand-700 font-semibold shrink-0">
          <Tag size={16} /> All Categories <ChevronDown size={14} />
        </button>
        {featured.map((f, i) => (
          <Link
            key={f}
            href="#"
            className={`shrink-0 hover:text-brand-700 ${i === 0 ? "text-deal font-semibold" : "text-ink-soft"}`}
          >
            {f}
          </Link>
        ))}
        <div className="h-4 w-px bg-line shrink-0" />
        {categories.slice(0, 6).map((c) => (
          <Link key={c.slug} href={`/category/${c.slug}`} className="shrink-0 text-ink-soft hover:text-brand-700">
            {c.name}
          </Link>
        ))}
      </div>
    </nav>
  );
}
