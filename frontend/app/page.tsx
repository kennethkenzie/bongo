import CategorySidebar from "@/components/home/CategorySidebar";
import HeroBanner from "@/components/home/HeroBanner";
import PromoColumn from "@/components/home/PromoColumn";
import PromoStrip from "@/components/home/PromoStrip";
import FlashDeals from "@/components/home/FlashDeals";
import SectionHeader from "@/components/home/SectionHeader";
import TopCategories from "@/components/home/TopCategories";
import HorizontalRail from "@/components/home/HorizontalRail";
import ProductGrid from "@/components/product/ProductGrid";
import { api } from "@/lib/api";
import Link from "next/link";

export default async function HomePage() {
  const data = await api.home();
  const { categories, flash_deals: flashDeals, recommended, trending, more_to_love: moreToLove } = data;

  return (
    <div className="space-y-2">
      {/* Mobile category shortcuts row */}
      <section className="md:hidden card p-3 -mx-3 rounded-none border-x-0">
        <div className="grid grid-cols-5 gap-3">
          {categories.slice(0, 10).map((c) => (
            <Link key={c.slug} href={`/category/${c.slug}`} className="flex flex-col items-center gap-1">
              <div className="w-12 h-12 rounded-sm overflow-hidden border border-line">
                {/* eslint-disable-next-line @next/next/no-img-element */}
                <img src={c.image} alt={c.name} className="w-full h-full object-cover" />
              </div>
              <span className="text-[10px] text-ink-soft line-clamp-1">{c.name.split(" ")[0]}</span>
            </Link>
          ))}
        </div>
      </section>

      {/* Hero + Sidebar + Promo column */}
      <section className="flex gap-3">
        <CategorySidebar categories={categories} />
        <HeroBanner />
        <PromoColumn />
      </section>

      {/* Promo strip */}
      <PromoStrip />

      {/* Flash deals */}
      <FlashDeals products={flashDeals} />

      {/* Top categories */}
      <SectionHeader title="Top Categories" href="/categories" />
      <TopCategories categories={categories} />

      {/* Recommended */}
      <SectionHeader title="Just For You" accent="Recommended" href="#" />
      <ProductGrid products={recommended} />

      {/* Trending */}
      <SectionHeader title="Trending Now" accent="Hot picks" href="#" />
      <HorizontalRail products={trending} />

      {/* More to love */}
      <SectionHeader title="More to Love" accent="Recently viewed" href="#" />
      <ProductGrid products={moreToLove} cols="dense" compact />
    </div>
  );
}
