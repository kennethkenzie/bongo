import ProductGrid from "@/components/product/ProductGrid";
import SectionHeader from "@/components/home/SectionHeader";
import { api } from "@/lib/api";
import { Star, MapPin, MessageCircle, Heart, ShieldCheck } from "lucide-react";
import Link from "next/link";

export default async function StorePage({ params }: { params: { id: string } }) {
  const { recommended, trending } = await api.home();
  const name = "Bongo Premium Store";
  return (
    <div>
      <div className="card overflow-hidden">
        <div className="h-32 md:h-44 bg-gradient-to-r from-brand-700 to-brand-400 relative">
          <div className="absolute inset-0 bg-[url('https://picsum.photos/seed/storehero/1400/300')] bg-cover bg-center mix-blend-overlay opacity-40" />
        </div>
        <div className="p-4 flex flex-col md:flex-row md:items-end gap-3 md:gap-5 -mt-10 md:-mt-12">
          <div className="w-20 h-20 md:w-24 md:h-24 rounded-sm border-4 border-white bg-brand-600 text-white grid place-items-center font-extrabold text-2xl shadow-card">
            B
          </div>
          <div className="flex-1">
            <h1 className="text-xl md:text-2xl font-extrabold">{name}</h1>
            <div className="flex items-center flex-wrap gap-3 text-xs text-ink-muted mt-1">
              <span className="flex items-center gap-1 text-brand-700 font-semibold"><Star size={12} fill="currentColor" /> 4.9</span>
              <span>·</span>
              <span>98.3% Positive Feedback</span>
              <span>·</span>
              <span className="flex items-center gap-1"><MapPin size={12} /> Dar es Salaam, Tanzania</span>
              <span>·</span>
              <span>Member since 2024</span>
            </div>
          </div>
          <div className="flex items-center gap-2">
            <button className="btn-outline text-sm py-1.5"><Heart size={14} className="mr-2" /> Follow</button>
            <button className="btn-outline text-sm py-1.5"><MessageCircle size={14} className="mr-2" /> Chat</button>
          </div>
        </div>
        <div className="grid grid-cols-4 border-t border-line text-center text-xs">
          {[
            { v: "12,432", l: "Followers" },
            { v: "486", l: "Products" },
            { v: "4.9 / 5", l: "Service" },
            { v: "98%", l: "On-time ship" },
          ].map((s) => (
            <div key={s.l} className="py-2.5">
              <div className="font-bold text-ink">{s.v}</div>
              <div className="text-ink-muted">{s.l}</div>
            </div>
          ))}
        </div>
      </div>

      <div className="flex items-center gap-2 mt-3 text-sm">
        <div className="card px-3 py-2 flex items-center gap-1 text-emerald-700">
          <ShieldCheck size={14} /> Verified Seller
        </div>
        <Link href="#" className="chip">Best sellers</Link>
        <Link href="#" className="chip">New arrivals</Link>
        <Link href="#" className="chip">Top rated</Link>
        <Link href="#" className="chip">On sale</Link>
      </div>

      <SectionHeader title="Store Highlights" href="#" />
      <ProductGrid products={recommended.slice(0, 10)} cols="dense" compact />

      <SectionHeader title="All Products" href="#" />
      <ProductGrid products={trending} cols="dense" compact />
    </div>
  );
}
