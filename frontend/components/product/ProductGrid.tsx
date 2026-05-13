import type { Product } from "@/lib/types";
import ProductCard from "./ProductCard";

export default function ProductGrid({
  products,
  cols = "default",
  compact = false
}: {
  products: Product[];
  cols?: "default" | "dense";
  compact?: boolean;
}) {
  const grid =
    cols === "dense"
      ? "grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6"
      : "grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5";
  return (
    <div className={`grid ${grid} gap-2 md:gap-3`}>
      {products.map((p) => (
        <ProductCard key={p.id} product={p} compact={compact} />
      ))}
    </div>
  );
}
