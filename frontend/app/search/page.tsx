import { api } from "@/lib/api";
import ProductGrid from "@/components/product/ProductGrid";
import { SlidersHorizontal, Search as SearchIcon } from "lucide-react";

export default async function SearchPage({ searchParams }: { searchParams: { q?: string } }) {
  const q = searchParams.q ?? "";
  const results = q ? (await api.search(q)).data : [];

  return (
    <div>
      <div className="card p-3 md:p-4 mb-3">
        <div className="flex items-center gap-2 text-sm">
          <SearchIcon size={16} className="text-brand-700" />
          <span className="text-ink-muted">Results for</span>
          <span className="font-semibold">"{q}"</span>
          <span className="ml-auto text-ink-muted text-xs">{results.length} products found</span>
        </div>
        <div className="flex items-center gap-2 mt-3 flex-wrap">
          {["Best Match", "Orders", "Price ↑", "Price ↓", "Newest", "Top rated"].map((s, i) => (
            <button key={s} className={`chip ${i === 0 ? "border-brand-600 text-brand-700 bg-brand-50" : ""}`}>{s}</button>
          ))}
          <button className="chip"><SlidersHorizontal size={12} /> Filters</button>
          <button className="chip">Free shipping</button>
          <button className="chip">4★ & up</button>
        </div>
      </div>

      {results.length > 0 ? (
        <ProductGrid products={results} cols="dense" compact />
      ) : (
        <div className="card p-10 text-center">
          <div className="text-4xl mb-2">🔍</div>
          <div className="font-semibold">No results for "{q}"</div>
          <p className="text-sm text-ink-muted mt-1">Try a different search term or browse categories.</p>
        </div>
      )}
    </div>
  );
}
