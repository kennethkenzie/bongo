import ProductGrid from "@/components/product/ProductGrid";
import { recommended, trending } from "@/lib/data";
import SectionHeader from "@/components/home/SectionHeader";

export default function WishlistPage() {
  return (
    <div>
      <h1 className="text-xl md:text-2xl font-bold mb-3">My Wishlist</h1>
      <ProductGrid products={recommended.slice(0, 10)} />
      <SectionHeader title="Inspired by your wishlist" href="#" />
      <ProductGrid products={trending} cols="dense" compact />
    </div>
  );
}
