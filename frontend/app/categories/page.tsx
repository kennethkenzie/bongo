import Link from "next/link";
import { api } from "@/lib/api";

export default async function CategoriesPage() {
  const categories = await api.categories();
  return (
    <div>
      <h1 className="text-xl md:text-2xl font-bold mb-3">All Categories</h1>
      <div className="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3">
        {categories.map((c) => (
          <Link key={c.slug} href={`/category/${c.slug}`} className="card overflow-hidden hover:border-brand-300 hover:shadow-pop transition">
            <div className="aspect-[4/3] overflow-hidden bg-surface">
              {/* eslint-disable-next-line @next/next/no-img-element */}
              <img src={c.image} alt={c.name} className="w-full h-full object-cover" />
            </div>
            <div className="p-3">
              <div className="font-medium text-ink text-sm">{c.name}</div>
              <div className="text-[11px] text-ink-muted">Browse all →</div>
            </div>
          </Link>
        ))}
      </div>
    </div>
  );
}
