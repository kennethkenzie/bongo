import { categories, moreToLove } from "@/lib/data";
import ProductGrid from "@/components/product/ProductGrid";
import SectionHeader from "@/components/home/SectionHeader";
import Link from "next/link";
import { notFound } from "next/navigation";
import { ChevronRight, SlidersHorizontal } from "lucide-react";

export default function CategoryPage({ params }: { params: { slug: string } }) {
  const cat = categories.find((c) => c.slug === params.slug);
  if (!cat) return notFound();
  return (
    <div>
      <nav className="text-xs text-ink-muted flex items-center gap-1 mb-3">
        <Link href="/" className="hover:text-brand-700">Home</Link>
        <ChevronRight size={12} />
        <span className="text-ink">{cat.name}</span>
      </nav>

      <div className="card p-3 md:p-4 flex flex-col md:flex-row gap-3 md:items-center md:justify-between">
        <div>
          <h1 className="text-xl md:text-2xl font-bold text-ink">{cat.name}</h1>
          <p className="text-sm text-ink-muted">Browse top deals on {cat.name.toLowerCase()}</p>
        </div>
        <div className="flex items-center gap-2 flex-wrap">
          {["Best Match", "Orders", "Price ↑", "Price ↓", "Newest"].map((s, i) => (
            <button key={s} className={`chip ${i === 0 ? "border-brand-600 text-brand-700 bg-brand-50" : ""}`}>{s}</button>
          ))}
          <button className="chip"><SlidersHorizontal size={12} /> Filters</button>
        </div>
      </div>

      <SectionHeader title={`Top picks in ${cat.name}`} href="#" />
      <ProductGrid products={moreToLove} cols="dense" compact />
    </div>
  );
}
